<?php

    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';

    if (isset($_POST['remover_grupo']) && $_POST['remover_grupo'] == "sim") {
        remover_grupo($conexao, $_POST['id']);
        die();
    }

    if (!isset($_POST['submit-remover-grupo'])) {
        $_SESSION['danger'] = "Não foi dado submit!";
        header("Location: ../perfil-usuario.php");
        die();
    }

    if (!isset($_POST['id'])) {
        $_SESSION['danger'] = "Não existe nenhum post para o id do grupo!";
        header("Location: ../perfil-usuario.php");
        die();
    }


    // Inicia a SESSAO
    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }

    remover_grupo($conexao, $_POST['id']);

    $_SESSION['success'] = "Grupo removido com sucesso";
    header("Location: ../perfil-usuario.php");
    die();