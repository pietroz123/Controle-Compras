<?php
    include("database/conexao.php"); 
    include("funcoes.php");
    include("logica-usuarios.php");

    verifica_usuario();

    $id = $_POST['id'];
    if (remover_compra($conexao, $id)) {

        $_SESSION['success'] = "Compra (ID = '{$id}') removida!";
        header("Location: listar-compras.php");
        die();

    } else {
        
        $_SESSION['danger'] = "Erro na remoção da compra (ID = '{$id}')!";
        header("Location: listar-compras.php");
        die();

    }
    mysqli_close($conexao);