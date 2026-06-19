<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>

    <link rel="shortcut icon" href="../../img/favicon/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/query.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>


<div class="telaErro">
    <h1>Ops, algo deu errado!</h1>
    <?php 
        if (isset($_SESSION["msg"])) {
            echo $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }
    ?>
</div>

<script>
const msgElement = document.getElementById('session-msg');

    if (msgElement) {
        setTimeout(() => {
            msgElement.style.display = 'none'; 
        }, 6000);
    }

</script>

</body>
</html>
