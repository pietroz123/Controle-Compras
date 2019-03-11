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

    if (isset($_POST['email'])) {

        // Recebe o Email da requisicao POST
        $email_usuario_temp = $_POST['email'];
        if (remover_usuario_temp($conexao, $email_usuario_temp)) {
            
            $_SESSION['success'] = "Requisição removida com sucesso.";
            header("Location: ../requisicoes.php");
            die();
    
        } else {
            
            $_SESSION['danger'] = "Erro na remoção da requisição.";
            header("Location: ../requisicoes.php");
            die();
        
        }

    }