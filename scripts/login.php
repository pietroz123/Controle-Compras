<?php

    if (isset($_POST['submit-login'])) {

        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
        include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
        include $_SERVER['DOCUMENT_ROOT'].'/includes/logica-usuarios.php';
        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
    
        $email_nome_usuario = $_POST['autenticacao'];
        $senha_usuario = $_POST['senha'];
    
        $usuario = buscar_usuario($conexao, $email_nome_usuario);
        
        if ($usuario == null) {
            $_SESSION['danger'] = "Usuário nao encontrado.";
            header("Location: ../index.php");
        } else {
            $verifica_senha = password_verify($senha_usuario, $usuario['Senha']);
            if ($verifica_senha == false) {
                $_SESSION['danger'] = "Usuário ou senha inválidos.";
                header("Location: ../index.php");
                die();
            }
            if ($usuario['Autenticado'] == 0) {
                $_SESSION['danger'] = "Usuário aguardando confirmação de cadastro.";
                header("Location: ../index.php");
                die();
            }
            $comprador = join_usuario_comprador($conexao, $usuario['Email']);
            login($usuario['Email'], $usuario['Usuario'], $comprador['Nome'], $comprador['ID']);
            $_SESSION['success'] = "Logado com sucesso.";
            header("Location: ../index.php");
        }
        die();

    }
