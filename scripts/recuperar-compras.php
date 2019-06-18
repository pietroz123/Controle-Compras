<?php
    include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';

    include $_SERVER['DOCUMENT_ROOT'].'/persistence/CompraDAO.php';
    include $_SERVER['DOCUMENT_ROOT'].'/persistence/GrupoDAO.php';


    // =======================================================
    // Recuperar todas as compras do usuário
    // =======================================================

    if ( isset($_POST['todas']) && $_POST['todas'] = 'sim' ) {

        $cdao = new CompraDAO();
        $json = $cdao->recuperarComprasUsuarioJSON($dbconn, $_SESSION['login-id-comprador'], $_POST);
        
        echo $json;

    }


    // =======================================================
    // Recuperar todas as compras de um grupo
    // =======================================================

    if ( isset($_POST['id_grupo']) ) {

        $id_grupo = $_POST['id_grupo'];

        $cdao = new CompraDAO();
        $json = $cdao->recuperarComprasGrupoJSON($dbconn, $id_grupo, $_POST);
        
        echo $json;
        
    }

    // =======================================================
    // Recuperar as compras de determinado dia
    // =======================================================
    
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