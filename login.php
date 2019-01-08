<?php
    include("database/conexao.php");
    include("funcoes-usuarios.php");
    include("logica-usuarios.php");
?>

<?php

    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }

    $email_nome_usuario = $_POST['autenticacao'];
    $senha_usuario = $_POST['senha'];

    $usuario = buscar_usuario($conexao, $email_nome_usuario);
    
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
        if ($usuario['Autenticado'] == 0) {
            $_SESSION['danger'] = "Usuário aguardando confirmação de cadastro.";
            header("Location: index.php");
            die();
        }
        login($usuario['Primeiro_Nome'], $usuario['Usuario']);
        $_SESSION['success'] = "Logado com sucesso.";
        header("Location: index.php");
    }
    die();