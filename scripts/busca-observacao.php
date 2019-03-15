<?php


    if (isset($_POST['busca']) && $_POST['busca'] == 'sim') {

        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';

        $observacao = strip_tags($_POST['texto']);
        
        /* Busca os usuários no Banco de Dados (menos o próprio usuário) */

        $sql = "SELECT DISTINCT `Observacoes` FROM `compras` WHERE `Observacoes` LIKE ?";
        $stmt = mysqli_stmt_init($conexao);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Erro
        
        } else {
            $observacao = '%'.$observacao.'%';
            mysqli_stmt_bind_param($stmt, "s", $observacao);
            mysqli_stmt_execute($stmt);

            $retorno = array();
            $resultado = mysqli_stmt_get_result($stmt);

            $i = 0;
            while ($observacao = mysqli_fetch_assoc($resultado)) {
                $retorno[] = array(
                    'id'    => $i,
                    'text'  => $observacao['Observacoes']
                );
                $i++;
            }

            echo json_encode($retorno);
        }

    }