<?php
    include("conexao.php");
    include("funcoes-usuarios.php");
?>

<?php

    $email_usuario = $_POST['email'];
    $senha_usuario = $_POST['senha'];

    $usuario = buscar_usuario($conexao, $email_usuario, $senha_usuario);
    var_dump($usuario);