<?php


    if (isset($_POST['busca']) && $_POST['busca'] == 'sim') {

        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
        include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';

        $usuario = strip_tags($_POST['texto']);
        
        /* Busca os usuários no Banco de Dados (menos o próprio usuário) */

        $sql = "SELECT * FROM `usuarios` WHERE `Usuario` LIKE ? AND `Autenticado` = 1 AND `Usuario` <> ?";
        
        if (!$stmt = $dbconn->prepare($sql)) {
            // Erro
        
        } else {
            $usuario = '%'.$usuario.'%';
            $stmt->bindParam(1, $usuario);
            $stmt->bindParam(2, $_SESSION['login-username']);
            $stmt->execute();

            $retorno = array();

            while ($usuario_retorno = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $retorno[] = array(
                    'id'    => $usuario_retorno['ID'],
                    'text'  => $usuario_retorno['Usuario']
                );
            }

            echo json_encode($retorno);
        }

    }