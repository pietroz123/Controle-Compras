<?php

    if (isset($_POST['requisicao'])) {

        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';

        // Recupera relatórios de acordo com uma requisição
        switch ($_POST['requisicao']) {
            
            // Recuperar as datas e valores de compras
            case 'datas-compras':

                $sql = "SELECT c.Data, c.Valor FROM compras c";
                $compras = array();
                $retorno = array();

                $resultado = mysqli_query($conexao, $sql);
                if ($resultado) {
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($compra = mysqli_fetch_assoc($resultado)) {
                            array_push($compras, $compra);
                        }
                    }
                }

                $retorno['compras'] = $compras;
                $retorno['qtd_compras'] = count($compras);

                echo json_encode($retorno);

                break;
            
            default:
                # code...
                break;
        }

    }