<?php
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/logica-usuarios.php';
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
        
        // !NAO FUNCIONA
        /* $usuario_temp = buscar_usuario_temp($conexao, $id_usuario_temp);
        enviar_email($usuario_temp['Email']);
        $_SESSION['success'] = "Usuario adicionado com sucesso. Email enviado para '" . $usuario_temp['Email'] . "'"; */
        
        $_SESSION['success'] = "Usuário adicionado com sucesso.";
        header("Location: requisicoes.php");
        die();
    } else {
        $_SESSION['danger'] = "Erro na adição do usuário.";
        header("Location: requisicoes.php");
        die();
    }
