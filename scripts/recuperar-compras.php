<?php
    include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';


    // =======================================================
    // Caso o usuário deseje visualizar suas próprias compras
    // =======================================================
    
    if (isset($_POST['id_comprador'])) {

        $id_comprador = $_POST['id_comprador'];

        // Recupera as compras
        $compras = recuperar_compras($dbconn, $id_comprador);

        $retorno = '';
        foreach ($compras as $compra) {

            $retorno .= '<tr>
                <td class="t-id">'.$compra['Id'].'</td>
                <td class="t-data">'.$compra['Data'].'</td>
                <td class="t-observacoes">'.$compra['Observacoes'].'</td>
                <td class="t-valor">'.$compra['Valor'].'</td>
                <td class="t-desconto">'.$compra['Desconto'].'</td>          
                <td class="t-pagamento">'.$compra['Forma_Pagamento'].'</td>
                <td class="t-comprador">'.$compra['Nome_Comprador'].'</td>
                <td class="t-imagem">
                    <button type="button" class="btn light-blue btn-block botao-pequeno btn-imagem" id="'.$compra['Id'].'">imagem</button>
                </td>
                <td class="t-alterar">
                    <form action="formulario-alterar-compra.php" method="post">
                        <input type="hidden" name="id" value="'.$compra['Id'].'">
                        <button class="btn btn-primary botao-pequeno">alterar</button>
                    </form>
                </td>
                <td class="t-remover">
                    <form action="scripts/remover-compra.php" method="post">
                        <input type="hidden" name="id" value="'.$compra['Id'].'">
                        <button class="btn btn-danger botao-pequeno" type="submit" name="submit-remover" onclick="return confirm(\'Deseja prosseguir com a remoção?\');">remover</button>
                    </form>
                </td>
                <td class="t-detalhes">
                    <button type="button" id="'.$compra['Id'].'" class="btn btn-info botao-pequeno btn-detalhes">detalhes</button>
                </td>
            </tr>';

        }

        echo $retorno;

    }
    
    
    // =======================================================
    // Caso o usuário deseje visualizar as compras de algum grupo
    // =======================================================
    
    if (isset($_POST['id_grupo'])) {

        $id_grupo = $_POST['id_grupo'];
        $grupo = recuperar_grupo($dbconn, $id_grupo);

        // Recupera os IDs dos Compradores que estão naquele grupo
        $ids_compradores = recuperar_compradores($dbconn, $id_grupo);
        $qtd_compradores = count($ids_compradores);

        // Recupera as compras com os IDs dos Compradores
        $sql = "SELECT cmp.*, cmpd.Nome AS Nome_Comprador
                FROM compras cmp 
                JOIN compradores cmpd ON cmp.Comprador_ID = cmpd.ID
                WHERE ";

        $i = 0;
        foreach ($ids_compradores as $id_comprador) {
            $i++;
            if ($i < $qtd_compradores)
                $sql .= "cmpd.ID = ".$id_comprador['ID']." OR ";
            else
                $sql .= "cmpd.ID = ".$id_comprador['ID']." ";
        }
        $sql .= "ORDER BY year(data), month(data), day(data)";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $compras = array();
        while ($compra = $stmt->fetch(PDO::FETCH_ASSOC))
            array_push($compras, $compra);

        $retorno = array();
        $retorno['titulo'] = $grupo['Nome'];

        $retorno['html'] = '';
        foreach ($compras as $compra) {

            $retorno['html'] .= '<tr>
                <td class="t-id">'.$compra['Id'].'</td>
                <td class="t-data">'.$compra['Data'].'</td>
                <td class="t-observacoes">'.$compra['Observacoes'].'</td>
                <td class="t-valor">'.$compra['Valor'].'</td>
                <td class="t-desconto">'.$compra['Desconto'].'</td>          
                <td class="t-pagamento">'.$compra['Forma_Pagamento'].'</td>
                <td class="t-comprador">'.$compra['Nome_Comprador'].'</td>
                <td class="t-imagem">
                    <button type="button" class="btn light-blue btn-block botao-pequeno btn-imagem" id="'.$compra['Id'].'">imagem</button>
                </td>
                <td class="t-alterar">
                    <form action="formulario-alterar-compra.php" method="post">
                        <input type="hidden" name="id" value="'.$compra['Id'].'">
                        <button class="btn btn-primary botao-pequeno">alterar</button>
                    </form>
                </td>
                <td class="t-remover">
                    <form action="scripts/remover-compra.php" method="post">
                        <input type="hidden" name="id" value="'.$compra['Id'].'">
                        <button class="btn btn-danger botao-pequeno" type="submit" name="submit-remover" onclick="return confirm(\'Deseja prosseguir com a remoção?\');">remover</button>
                    </form>
                </td>
                <td class="t-detalhes">
                    <button type="button" id="'.$compra['Id'].'" class="btn btn-info botao-pequeno btn-detalhes">detalhes</button>
                </td>
            </tr>';

        }

        echo json_encode($retorno);
    }

    // Caso o usuário tenha clicado no gráfico de relatórios para ver as compras de determinado dia
    if (isset($_POST['data_compra'])) {

        $data_compra = $_POST['data_compra'];

        $email = $_SESSION['login-email'];
        $sql = "SELECT c.Observacoes, c.Valor, c.Desconto, c.Forma_Pagamento, c.Imagem, c.Comprador_ID
                FROM compras c
                WHERE c.Data = '$data_compra'
                AND c.Comprador_ID = (
                    SELECT co.ID
                    FROM compradores co
                    WHERE co.Email = '$email'
                );";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $retorno = '';
        $retorno .= '<table class="table table-hover datatable-compras" id="tabela-compras">
    
            <thead class="thead-dark">
                <tr>
                    <th class="th-sm">Observacoes</th>
                    <th class="th-sm">Valor</th>
                    <th class="th-sm">Pagamento</th>
                </tr>
            </thead>
        
            <tbody id="compras-datatable">';

            // Preenche com as compras
            $compras = array();
            while ($compra = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($compras, $compra);
                $retorno .= '<tr>
                    <td>'.$compra['Observacoes'].'</td>
                    <td>'.$compra['Valor'].'</td>
                    <td>'.$compra['Forma_Pagamento'].'</td>
                </tr>';
            }

            $retorno .= '</tbody></table>';

        echo $retorno;

    }