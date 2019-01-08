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
        
        // !NAO FUNCIONA
        /* $usuario_temp = buscar_usuario_temp($conexao, $id_usuario_temp);
        enviar_email($usuario_temp['Email']);
        $_SESSION['success'] = "Usuario adicionado com sucesso. Email enviado para '" . $usuario_temp['Email'] . "'"; */
        
        $_SESSION['success'] = "Usuario adicionado com sucesso.";
        header("Location: requisicoes.php");
        die();
    } else {
        $_SESSION['danger'] = "Erro na adicao do usuario.";
        header("Location: requisicoes.php");
        die();
    }
