Analisando o seu código, identifiquei **três problemas principais** que estão causando os erros de exibição dos preços, divergência no valor final do pedido e até mesmo o salvamento com valores incorretos no banco de dados.

---

## 🛠️ Diagnóstico dos Problemas

1. **Tentativa de usar `$_SESSION['produtos']` de forma solta:**
* Na ação `carregarQuantidade`, você salvava `$_SESSION['produtos'][$produto['id_produto']] = $produto['valor_unitario']`. Porém, ao limpar a sessão na hora de salvar/alterar ou navegar, esses dados ficavam desatualizados ou incompletos.


2. **Reescrita do valor unitário na ação `alterar` no `PedidoDAO`:**
* Ao alterar o pedido, o método `alterarPedido` limpava a tabela `pedido_produto` e inseria tudo novamente buscando o preço atual da tabela `produtos` (`SELECT valor_unitario FROM produtos WHERE id_produto = ?`).
* **Consequência:** Se o preço do produto no cadastro mudasse após a criação da venda, ao alterar a data ou status da venda, **o histórico de preços do pedido era sobrescrito pelo preço novo do cadastro**, alterando retroativamente o valor total e salvando errado no banco.


3. **Múltiplos valores unitários salvos na Session:**
* O ideal é guardar os detalhes dos itens (quantidade + valor unitário da época/histórico) estruturados dentro do próprio carrinho.



---

## 💡 Soluções Passo a Passo

### 1. Ajuste no `pedidoControle.php`

Estruture o carrinho na sessão para armazenar um array contendo a **quantidade** e o **valor unitário** do produto retornado pela consulta `buscarPedidoID`.

#### Em `case "carregarQuantidade":`

Substitua o trecho do `foreach` por:

```php
if (!empty($pedido)) {
    $_SESSION['carrinho'] = [];
    unset($_SESSION['produtos']); // Limpa a variável desnecessária

    foreach ($pedido['produtos'] as $produto) {
        // Armazena quantidade e valor_unitario juntos por produto
        $_SESSION['carrinho'][$produto['id_produto']] = [
            'quantidade' => $produto['quantidade'],
            'valor_unitario' => $produto['valor_unitario']
        ];
    }
    // ... resto do código mantido ...

```

#### Em `case "adicionarQuantidade":`

Ganta que, ao adicionar ou alterar um item manualmente na tela de edição, se o item já estiver no carrinho, ele preserve o valor salvo ou pegue o valor atual do cadastro de produtos:

```php
if ($id_produto > 0 && $quantidade > 0) {
    // Se o produto já existia no carrinho (veio do banco), mantém o valor_unitario antigo, senão busca o atual
    $valor_unitario = $_SESSION['carrinho'][$id_produto]['valor_unitario'] ?? null;

    if ($valor_unitario === null) {
        $prodAtual = $produtoDAO->buscarPorId($id_produto);
        $valor_unitario = $prodAtual['valor_unitario'] ?? 0;
    }

    $_SESSION['carrinho'][$id_produto] = [
        'quantidade' => $quantidade,
        'valor_unitario' => $valor_unitario
    ];
    $_SESSION['msg'] = "<p class='success-msg'>Quantidade atualizada no pedido.</p>";
}

```

---

### 2. Ajuste na Classe `PedidoDAO.class.php`

Na função `alterarPedido`, utilize o `valor_unitario` que está salvo na sessão em `$_SESSION['carrinho']`. Caso não exista, utilize o preço do cadastro de produtos como *fallback*.

Substitua o trecho correspondente no método `alterarPedido`:

```php
// ... dentro de alterarPedido()
$delete_relacao = $this->conexao->prepare("DELETE FROM pedido_produto WHERE id_pedido = ?");
$delete_relacao->execute([$pedido->id_pedido]);

$sql_produto = "INSERT INTO pedido_produto (id_pedido, id_produto, quantidade, valor_unitario) VALUES (?, ?, ?, ?)";
$stmt_produto = $this->conexao->prepare($sql_produto);

foreach ($_SESSION['carrinho'] as $id_produto => $item) {
    // Suporta tanto o formato antigo (int) quanto o novo formato (array)
    if (is_array($item)) {
        $quantidade = $item['quantidade'];
        $valor_unitario = $item['valor_unitario'];
    } else {
        $quantidade = $item;
        $stmt_preco = $this->conexao->prepare("SELECT valor_unitario FROM produtos WHERE id_produto = ?");
        $stmt_preco->execute([$id_produto]);
        $prod = $stmt_preco->fetch(PDO::FETCH_ASSOC);
        $valor_unitario = $prod ? $prod['valor_unitario'] : 0;
    }

    $stmt_produto->execute([$pedido->id_pedido, $id_produto, $quantidade, $valor_unitario]);
}

```

---

### 3. Ajustes nas Views (`gui_alteracao_pedidos.php`, `gui_alteracao_pedido_vendido.php`, `gui_alteracao_pedido_cancelado.php`)

Nas páginas de alteração, percorra o carrinho verificando a estrutura e exibindo diretamente os valores gravados:

```php
$_SESSION['total_compra'] = 0.00;

if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $id_produto => $item) {
        $produtoVendido = $produtoDAO->buscarPorId($id_produto);

        // Trata item como array ou inteiro simples (compatibilidade)
        if (is_array($item)) {
            $quantidade = (int)$item['quantidade'];
            $valor_unitario = (float)$item['valor_unitario'];
        } else {
            $quantidade = (int)$item;
            $valor_unitario = (float)($produtoVendido['valor_unitario'] ?? 0);
        }

        $valor_total_item = $valor_unitario * $quantidade;
        $_SESSION['total_compra'] += $valor_total_item;

        if ($produtoVendido) {
            echo "<div class='produto-individual'>";
            echo "<h3>" . htmlspecialchars($produtoVendido['nome']) . "</h3><br>";
            echo "<p>";
            echo "<b>Quantidade</b>: " . $quantidade . "<br>";
            echo "<b>Unidade</b>: R$ " . number_format($valor_unitario, 2, ',', '.') . "<br>";
            echo "<b>Valor total</b>: R$ " . number_format($valor_total_item, 2, ',', '.') . "<br><br>";
            
            // Exibir o botão de remoção apenas se for a tela de alteração normal
            if (basename($_SERVER['PHP_SELF']) == 'gui_alteracao_pedidos.php') {
                echo "<a href='../controller/pedidoControle.php?op=removerQuantidade&id=$id_produto&id_pedido=$id_pedido' class='btn-remover'>Remover produto</a>";
            }
            
            echo "</div>";
        } else {
            echo "<p><b>Produto ID $id_produto</b> não foi encontrado no estoque.</p>";
        }
    }
} else {
    echo "<p>Nenhum produto encontrado no pedido.</p>";
}

```

Com essas correções, a `$_SESSION['produtos']` pode ser totalmente removida, os valores exibidos e recalculados preservam com fidelidade o histórico gravado no banco de dados na tabela `pedido_produto`, e o valor final gravado na tabela `pedidos` baterá exatamente com os totais exibidos.