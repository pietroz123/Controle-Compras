<?php

    if (isset($_POST['requisicao'])) {

        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';

        // Recupera relatórios de acordo com uma requisição
        switch ($_POST['requisicao']) {
            
            // Recuperar as datas e valores de compras
            case 'datas-compras':

                $email = $_SESSION['login-email'];
                $sql = "SELECT c.Data, c.Valor
                        FROM compras c
                        WHERE year(c.Data) = 2019
                        AND c.Comprador_ID = (
                            SELECT co.ID
                            FROM compradores co
                            WHERE co.Email = '$email'
                        )
                        ORDER BY YEAR(c.Data), MONTH(c.Data), DAY(c.Data);";

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