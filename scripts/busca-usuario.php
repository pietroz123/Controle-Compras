<?php


    if (isset($_POST['busca']) && $_POST['busca'] == 'sim') {

        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';

        $usuario = strip_tags($_POST['texto']);
        
        /* Busca o usuário no Banco de Dados */
        $sql = "SELECT * FROM `usuarios` WHERE `Usuario` LIKE ?";
        $stmt = mysqli_stmt_init($conexao);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Erro
        } else {
            $usuario = '%'.$usuario.'%';
            mysqli_stmt_bind_param($stmt, "s", $usuario);
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