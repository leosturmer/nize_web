
Para criar um sistema de **reset de senha seguro**, o fluxo correto **não exige descriptografar a senha antiga** (pois hashes com `password_hash` são unidirecionais e impossíveis de descriptografar).

Em vez disso, gera-se um **token temporário e único**, que é salvo no banco e enviado por e-mail para o usuário. O usuário clica no link, define a nova senha e o sistema grava o novo `password_hash()`.

---

### Fluxo Completo de Reset de Senha

#### 1. Alterações necessárias no Banco de Dados

Adicione duas colunas na tabela de usuários para armazenar o token e sua validade:

```sql
ALTER TABLE usuario ADD COLUMN reset_token TEXT NULL;
ALTER TABLE usuario ADD COLUMN reset_token_expira DATETIME NULL;

```

---

#### 2. Etapa 1: Solicitar o Reset (Formulário e Controller)

Quando o usuário digita o e-mail para recuperar a senha:

```php
// esqueci_senha.php (Ao enviar o formulário com o e-mail)
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if ($email) {
    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->buscarEmail($email);

    if ($usuario) {
        // 1. Gera um token aleatório e seguro de 64 caracteres
        $token = bin2hex(random_bytes(32));

        // 2. Define validade de 30 minutos
        $expiracao = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        // 3. Salva o token e a expiração no banco para este usuário
        $usuarioDAO->salvarTokenReset($usuario['id_usuario'], $token, $expiracao);

        // 4. Cria o link de redefinição
        $link = "https://seudominio.com/view/redefinir_senha.php?token=" . $token;

        // 5. Envia por e-mail (usando PHPMailer, mail(), etc.)
        $mensagem = "Olá! Clique no link a seguir para redefinir sua senha: " . $link;
        // enviarEmail($email, "Recuperação de Senha", $mensagem);

        $_SESSION['msg'] = "<p class='success-msg'>Se o e-mail estiver cadastrado, você receberá o link de recuperação!</p>";
    } else {
        // Por segurança, exiba a mesma mensagem para evitar que descubram se o e-mail existe
        $_SESSION['msg'] = "<p class='success-msg'>Se o e-mail estiver cadastrado, você receberá o link de recuperação!</p>";
    }
}

```

---

#### 3. Etapa 2: Validar o Token e Exibir Tela da Nova Senha (`redefinir_senha.php`)

Quando o usuário clica no link recebido por e-mail:

```php
$token = $_GET['token'] ?? '';

$usuarioDAO = new UsuarioDAO();
// Busca o usuário apenas se o token for igual e o horário atual for MENOR que o limite de expiração
$usuario = $usuarioDAO->buscarPorTokenValido($token);

if (!$usuario) {
    die("Token inválido ou expirado. Por favor, solicite um novo reset de senha.");
}
?>

<!-- Formulário para digitar a nova senha -->
<form action="../controller/usuarioControle.php?op=salvarNovaSenha" method="post">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    
    <label>Nova Senha:</label>
    <input type="password" name="nova_senha" required minlength="6">

    <button type="submit">Salvar Nova Senha</button>
</form>

```

---

#### 4. Etapa 3: Criptografar e Atualizar a Nova Senha no Banco

Quando o formulário com a nova senha é enviado:

```php
// No usuarioControle.php (case 'salvarNovaSenha')
$token = $_POST['token'] ?? '';
$novaSenha = $_POST['nova_senha'] ?? '';

if (!empty($token) && !empty($novaSenha)) {
    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->buscarPorTokenValido($token);

    if ($usuario) {
        // 1. Gera a HASH da nova senha
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        // 2. Atualiza a senha no banco e LIMPA o token para não ser reutilizado
        if ($usuarioDAO->atualizarSenhaELimparToken($usuario['id_usuario'], $senhaHash)) {
            $_SESSION['msg'] = "<p class='success-msg'>Senha redefinida com sucesso! Faça login.</p>";
            header("Location: ../view/login.php");
            exit;
        }
    }
}

$_SESSION['msg'] = "<p class='error-msg'>Não foi possível redefinir a senha. Tente novamente.</p>";
header("Location: ../view/login.php");
exit;

```

---

#### 5. Funções no `UsuarioDAO.php`

```php
public function salvarTokenReset($id_usuario, $token, $expiracao) {
    $sql = $this->conexao->prepare("UPDATE usuario SET reset_token = ?, reset_token_expira = ? WHERE id_usuario = ?");
    return $sql->execute([$token, $expiracao, $id_usuario]);
}

public function buscarPorTokenValido($token) {
    $sql = $this->conexao->prepare("SELECT * FROM usuario WHERE reset_token = ? AND reset_token_expira > DATETIME('now', 'localtime')");
    $sql->execute([$token]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}

public function atualizarSenhaELimparToken($id_usuario, $novaSenhaHash) {
    $sql = $this->conexao->prepare("UPDATE usuario SET senha = ?, reset_token = NULL, reset_token_expira = NULL WHERE id_usuario = ?");
    return $sql->execute([$novaSenhaHash, $id_usuario]);
}

```

---

### 🛡️ Boas Práticas de Segurança

1. **Nunca envie a senha direto por e-mail** (nem em texto puro, nem em hash).
2. **Defina expiração curta para o token** (entre 15 a 30 minutos).
3. **Invalide o token imediatamente** após o uso para impedir reenvios.
4. **Use `random_bytes()**` para gerar o token. Evite funções previsíveis como `rand()` ou `uniqid()`.