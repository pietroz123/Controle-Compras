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
    if (adicionar_usuario_definitivo($conexao, $id_usuario_temp)) {
        $_SESSION['success'] = "Usuario adicionado com sucesso.";
        header("Location: requisicoes.php");
        die();
    } else {
        $_SESSION['danger'] = "Erro na adicao do usuario.";
        header("Location: requisicoes.php");
        die();
    }
