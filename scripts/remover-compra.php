<?php

if (isset($_POST['submit-remover'])) {

    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/logica-usuarios.php';

    verifica_usuario();

    $id = $_POST['id'];
    if (remover_compra($dbconn, $id)) {

        $_SESSION['success'] = "Compra (ID = '{$id}') removida!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        die();

    } else {
        
        $_SESSION['danger'] = "Erro na remoção da compra (ID = '{$id}')!";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        die();

    }

}