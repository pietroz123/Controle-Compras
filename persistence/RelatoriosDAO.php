<?php

/**
 * Description of RelatoriosDAO
 *
 * @author Pietro
 */
class RelatoriosDAO {
    
    /**
     * Recupera cada data que contenha uma ou mais compras, e a soma dos 
     * valores das compras daquela data, de um dado ano
     * 
     * @param PDO       $dbconn: Conexão com o BD
     * @param int       $ano: Ano especificado
     * 
     * @return array    $retorno: Contém as compras (Data, Soma) e a quantidade de compras
     */
    function recuperarDatasValores($dbconn, $ano) {

        // Para recuperação do email do usuário logado
        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
        $email = $_SESSION['login-email'];

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

        return $retorno;

    }

    /**
     * Recupera os anos disponíveis para visualização das estatísicas das compras
     * 
     * @param PDO       $dbconn: Conexão com o BD
     * 
     * @return string   $retorno: HTML com as options
     */
    function recuperarAnosDisponiveis($dbconn) {

        $sql = "SELECT DISTINCT YEAR(c.Data) as Ano
        FROM compras c
        WHERE c.Comprador_ID = (
            SELECT co.ID
            FROM compradores co
            WHERE co.Email = '".$_SESSION['login-email']."'
        )";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $retorno = '';
        while ($ano = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="cartao-ano waves-effect">
                <a role="button">
                    <div class="container">
                        <span class="ano"><?= $ano['Ano'] ?></span>
                    </div>
                </a>
            </div>
        <?php
        }

    }
    
    
}
