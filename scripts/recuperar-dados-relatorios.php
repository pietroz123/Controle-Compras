<?php

    if (isset($_POST['requisicao'])) {

        include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';
        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';

        include $_SERVER['DOCUMENT_ROOT'].'/persistence/RelatoriosDAO.php';

        
        // Recupera relatórios de acordo com uma requisição
        switch ($_POST['requisicao']) {
            
            // Recuperar as datas e valores de compras
            case 'datas-compras':

                // Recupera o ano especificado
                $ano = $_POST['ano'];

                $rdao = new RelatoriosDAO();
                echo json_encode($rdao->recuperarDatasValores($dbconn, $ano));

                break;

            // Recupera os anos disponíveis para visualização de estatísicas
            case 'anos-disponiveis':

                $rdao = new RelatoriosDAO();
                echo $rdao->recuperarAnosDisponiveis($dbconn);

                break;
            
            default:
                # code...
                break;
        }

    }