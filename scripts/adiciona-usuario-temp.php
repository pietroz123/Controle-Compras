<?php
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/logica-usuarios.php';

    verifica_usuario();


    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';

    if (isset($_POST['id'])) {

        // Recebe o ID da requisicao POST
        $id_usuario_temp = $_POST['id'];
        if (adicionar_usuario_definitivo($dbconn, $id_usuario_temp)) {
            
            $_SESSION['success'] = "Usuário adicionado com sucesso.";
            header("Location: ../perfil-usuario.php");
            die();
    
        } else {
            
            $_SESSION['danger'] = "Erro na adição do usuário.";
            header("Location: ../perfil-usuario.php");
            die();
        
        }

    }