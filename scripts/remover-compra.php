<?php
    include $_SERVER['DOCUMENT_ROOT'].'/compras/database/conexao.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/compras/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/compras/includes/logica-usuarios.php';

    verifica_usuario();

    $id = $_POST['id'];
    if (remover_compra($conexao, $id)) {

        $_SESSION['success'] = "Compra (ID = '{$id}') removida!";
        header("Location: ../listar-compras.php");
        die();

    } else {
        
        $_SESSION['danger'] = "Erro na remoção da compra (ID = '{$id}')!";
        header("Location: ../listar-compras.php");
        die();

    }
    mysqli_close($conexao);