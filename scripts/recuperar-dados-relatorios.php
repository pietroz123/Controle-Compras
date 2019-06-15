<?php

    if (isset($_POST['requisicao'])) {

        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
        include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';
        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';

        // Recupera relatórios de acordo com uma requisição
        switch ($_POST['requisicao']) {
            
            // Recuperar as datas e valores de compras
            case 'datas-compras':

                $email = $_SESSION['login-email'];
                $ano = $_POST['ano'];
                
                // Recupera a data e a soma dos valores daquela data (ordenados por ano, mês e dia e agrupados por data)
                $sql = "SELECT c.Data, sum(c.Valor) as Valor
                        FROM compras c
                        WHERE year(c.Data) = $ano
                        AND c.Comprador_ID = (
                            SELECT co.ID
                            FROM compradores co
                            WHERE co.Email = '$email'
                        )
                        GROUP BY c.Data
                        ORDER BY YEAR(c.Data), MONTH(c.Data), DAY(c.Data);";

                $compras = array();
                $retorno = array();

                $stmt = $dbconn->prepare($sql);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while ($compra = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        array_push($compras, $compra);
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