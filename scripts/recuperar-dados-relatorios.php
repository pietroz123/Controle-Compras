<?php

    if (isset($_POST['requisicao'])) {

        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';

        // Recupera relatórios de acordo com uma requisição
        switch ($_POST['requisicao']) {
            
            // Recuperar as datas e valores de compras
            case 'datas-compras':

                break;
            
            default:
                # code...
                break;
        }

    }