<?php
    include("funcoes-usuarios.php");
    include("database/conexao.php");
    include("logica-usuarios.php");
?>

<?php
    verifica_usuario();
?>

<?php

    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }

    // Recebe o ID da requisicao POST
    $id_usuario_temp = $_POST['id'];

    // Recupera o usuario temporario correspondente
    $usuario_temp = buscar_usuario_temp($conexao, $id_usuario_temp);

    // Dados do usuario temporario
    $nome = $usuario_temp['Primeiro_Nome'];
    $sobrenome = $usuario_temp['Sobrenome'];
    $username = $usuario_temp['Usuario'];
    $email = $usuario_temp['Email'];
    $senha = $usuario_temp['Senha'];

    // Insere o usuario
    if (adicionar_usuario_definitivo($conexao, $nome, $sobrenome, $username, $email, $senha)) {
        remover_usuario_temp($conexao, $id_usuario_temp);
        $_SESSION['success'] = "Usuario adicionado com sucesso.";
        header("Location: requisicoes.php");
        die();
    } else {
        $_SESSION['danger'] = "Erro na adicao do usuario.";
        header("Location: requisicoes.php");
        die();
    }
