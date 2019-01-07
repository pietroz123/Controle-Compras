<?php
    include("conexao.php");
    include("funcoes-usuarios.php");
    include("logica-usuarios.php");
?>

<?php

    if (!isset($_POST['submit'])) {
        $_SESSION['danger'] = "Voce nao deu submit!";
        header("Location: index.php");
        die();
    }

    // Pega os dados da requisicao POST
    $email_cadastro = $_POST['email'];
    $senha_cadastro = $_POST['senha'];
    $senha_rep_cadastro = $_POST['senha-rep'];

    // Verifica se existem campos em branco
    if (empty($email_cadastro) || empty($senha_cadastro) || empty($senha_rep_cadastro)) {
        $_SESSION['danger'] = "Existem campos em branco!";
        header("Location: index.php");
        die();
    }

    // Cria o usuario
    if (criar_usuario($conexao, $email_cadastro, $senha_cadastro)) {
        $_SESSION['success'] = "Cadastrado com sucesso. Favor efetuar o login no Menu de Navegacao.";
        header("Location: index.php");
        die();
    } else {
        $_SESSION['danger'] = "Erro ao cadastrar.";
        header("Location: index.php");
        die();
    }
