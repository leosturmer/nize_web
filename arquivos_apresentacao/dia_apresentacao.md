- Copiar todos arquivos para um pendrive
- Levar um banco de dados pronto
- Levar as fotos dos produtos (!!!!)

- Levar os arquivos do banco de dados / PHP para poder configurar

- Ver de novo no Senac como configurar <code>php --ini</code>


Para funcionar o banco:

- Baixar arquivo do **sqlite-tools-win-x64-3530200.zip** [https://sqlite.org/download.html](https://sqlite.org/download.html);
- Ir em VARIÁVEIS DE AMBIENTE DO USUÁRIO, em PATH e adicionar o caminho para a pasta do SQLite3 (ex: C:\xampp\sqlite);

- No CMD, dar **php --ini**, copiar o caminho que aparece e dar **code <caminho copiado>** para abrir no VS Code;
  - No VS Code, dar CTRL + F e pesquisar por sqlite e ativar o PDO sqlite e o sqlite3;

Para abrir:

- Ir na pasta onde está salvo o projeto e abrir o CMD;
- Dar o comando **php -S localhost:8000 **