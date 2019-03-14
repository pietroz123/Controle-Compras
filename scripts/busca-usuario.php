<?php


    if (isset($_POST['busca']) && $_POST['busca'] == 'sim') {

        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';

        $usuario = strip_tags($_POST['texto']);
        
        /* Busca os usuários no Banco de Dados (menos o próprio usuário) */

        $sql = "SELECT * FROM `usuarios` WHERE `Usuario` LIKE ? AND `Autenticado` = 1 AND `Usuario` <> ?";
        $stmt = mysqli_stmt_init($conexao);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Erro
        
        } else {
            $usuario = '%'.$usuario.'%';
            mysqli_stmt_bind_param($stmt, "ss", $usuario, $_SESSION['login-username']);
            mysqli_stmt_execute($stmt);

            $retorno = array();
            $resultado = mysqli_stmt_get_result($stmt);

            while ($usuario_retorno = mysqli_fetch_assoc($resultado)) {
                $retorno[] = array(
                    'id'    => $usuario_retorno['ID'],
                    'text'  => $usuario_retorno['Usuario']
                );
            }

            echo json_encode($retorno);
        }

    }