<?php
    include $_SERVER['DOCUMENT_ROOT'].'/includes/logica-usuarios.php';
    
    verifica_usuario();
    
    if (isset($_POST['submit-alterar'])) {
        
        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php'; 
        include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';

        $id                 = $_POST['id'];
        $valor              = $_POST['valor'];
        $data               = $_POST['data'];
        $observacoes        = $_POST['observacoes'];
        $desconto           = $_POST['desconto'];
        $forma_pagamento    = $_POST['forma-pagamento'];
        $comprador_id       = $_POST['comprador-id'];
        
        if (alterar_compra($conexao, $id, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id)) {
    
            $_SESSION['success'] = "Compra (ID = '{$id}') alterada!";
            header("Location: ../listar-compras.php");
            die();
    
        } else {
    
            $_SESSION['danger'] = "Erro na alteração da compra (ID = '{$id}')!" . mysql_error($conexao);
            header("Location: ../listar-compras.php");
            die();
    
        }
        mysqli_close($conexao);

    }
