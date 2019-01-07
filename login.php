<?php
    include("database/conexao.php");
    include("funcoes-usuarios.php");
    include("logica-usuarios.php");
?>

<?php

    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }

    $email_usuario = $_POST['email'];
    $senha_usuario = $_POST['senha'];

    $usuario = buscar_usuario($conexao, $email_usuario, $senha_usuario);
    
    if ($usuario == null) {
        $_SESSION['danger'] = "Usuário nao encontrado.";
        header("Location: index.php");
    } else {
        $verifica_senha = password_verify($senha_usuario, $usuario['Senha']);
        if ($verifica_senha == false) {
            $_SESSION['danger'] = "Usuário ou senha inválidos.";
            header("Location: index.php");
            die();
        }
        login($email_usuario);
        $_SESSION['success'] = "Logado com sucesso.";
        header("Location: index.php");
    }
    die();