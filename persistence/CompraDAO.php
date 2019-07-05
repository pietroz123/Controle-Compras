<?php

/**
 * Description of CompraDAO
 *
 * @author Pietro
 */
class CompraDAO {
    
    /**
     * Recupera todas as compras de um grupo
     * 
     * @param PDO $dbconn
     * @param int $id_grupo
     * 
     * @return array[Compra] $compras
     */
    public static function recuperarComprasGrupo($dbconn, $id_grupo) {
        
        $ids_compradores = GrupoDAO::recuperarCompradoresGrupo($dbconn, $id_grupo);

        $sql = 'SELECT c.*, cmpd.Nome AS Nome_Comprador
        FROM compras c
        JOIN compradores cmpd ON c.Comprador_ID = cmpd.ID
        WHERE cmpd.ID IN (';

        foreach ($ids_compradores as $id) {
            $sql .= $id['ID'];
            if ($id != end($ids_compradores))
                $sql .= ',';
        }

        $sql .= ')';

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $compras = $stmt->fetchAll();

        return $compras;

    }


    /**
     * Recupera as compras de um usuário em formato JSON
     * 
     * @param PDO   $dbconn         : Conexão com o BD
     * @param int   $id_usuario     : ID do Usuário
     * @param array $post           : Requisição POST com todo o cabeçalho do DataTables ServerSide
     */
    function recuperarComprasUsuarioJSON($dbconn, $id_usuario, $post) {

        /**
         * Sem nenhum filtro (todas as compras)
         */

        $sql = "SELECT c.*, cmpd.Nome AS Nome_Comprador
        FROM compras c
        JOIN compradores cmpd ON c.Comprador_ID = cmpd.ID
        WHERE cmpd.ID = $id_usuario";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->fetchAll();
        
        $qtd_total = count($rs);


        /**
         * COM LIMIT
         */

        $sql = "SELECT c.*, cmpd.Nome AS Nome_Comprador
        FROM compras c
        JOIN compradores cmpd ON c.Comprador_ID = cmpd.ID
        WHERE cmpd.ID = $id_usuario ";

        // =======================================================
        // Campo de busca
        // =======================================================

        if (!empty($post['search']['value']))
            $sql .= 'AND c.Observacoes LIKE \'%'.strtoupper($post['search']['value']).'%\' ';

        // =======================================================
        // Ordenação
        // =======================================================

        switch ($post['order'][0]['column']) {
            case 0:
                $sql .= 'ORDER BY c.Id '.$post['order'][0]['dir'].' ';
                break;
            case 1:
                $sql .= 'ORDER BY c.Data '.$post['order'][0]['dir'].' ';
                break;
            case 2:
                $sql .= 'ORDER BY c.Observacoes '.$post['order'][0]['dir'].' ';
                break;
            case 3:
                $sql .= 'ORDER BY c.Valor '.$post['order'][0]['dir'].' ';
                break;
            case 4:
                $sql .= 'ORDER BY c.Desconto '.$post['order'][0]['dir'].' ';
                break;
            case 5:
                $sql .= 'ORDER BY c.Forma_Pagamento '.$post['order'][0]['dir'].' ';
                break;
            case 6:
                $sql .= 'ORDER BY c.Comprador_ID '.$post['order'][0]['dir'].' ';
                break;
            
            default:
                # code...
                break;
        }

        // =======================================================
        // Limite e Deslocamento
        // =======================================================

        $sql .= 'LIMIT '.$post['length'].' OFFSET '.$post['start'];

        

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $compras = $stmt->fetchAll();


        /**
         * SEM LIMIT (mas com filtros)
         */

        $sql = "SELECT c.*, cmpd.Nome AS Nome_Comprador
        FROM compras c
        JOIN compradores cmpd ON c.Comprador_ID = cmpd.ID
        WHERE cmpd.ID = $id_usuario ";

        // =======================================================
        // Campo de busca
        // =======================================================

        if (!empty($post['search']['value']))
            $sql .= 'AND c.Observacoes LIKE \'%'.strtoupper($post['search']['value']).'%\' ';



        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->fetchAll();

        $qtd_filtrada = count($rs);





        
        // =======================================================
        // Cria o JSON
        // =======================================================
        
        $json = '{
            "draw": '.$post['draw'].',
            "recordsTotal": '.$qtd_total.',
            "recordsFiltered": '.$qtd_filtrada.',
            "data": [';

        $total = count($compras);
        $i = 1;
        foreach ($compras as $compra) {
            
            // Cria o botão de edição
            $btnEdit = "<button type='button' id-compra='".$compra['Id']."' class='btn-detalhes'><i class='fas fa-edit'></i></button>";

            $json .= '[
                        "'.$compra['Observacoes'].'",
                        "'.$compra['Data'].'",
                        "'.$compra['Id'].'",
                        "'.$compra['Valor'].'",
                        "'.$compra['Desconto'].'",
                        "'.$compra['Forma_Pagamento'].'",
                        "'.$compra['Nome_Comprador'].'",
                        "'.$btnEdit.'"
                    ]';
            if ($i < $total)
                $json .= ',';
            $i++;
        
        }

        $json .= ']}';

        return $json;

    }


    /**
     * Recupera as compras de um grupo em formato JSON
     * 
     * @param PDO   $dbconn         : Conexão com o BD
     * @param int   $id_grupo       : ID do Grupo
     * @param array $post           : Requisição POST com todo o cabeçalho do DataTables ServerSide
     */
    function recuperarComprasGrupoJSON($dbconn, $id_grupo, $post) {

        $ids_compradores = GrupoDAO::recuperarCompradoresGrupo($dbconn, $id_grupo);

        /**
         * Sem nenhum filtro (todas as compras)
         */

        $sql = 'SELECT c.*, cmpd.Nome AS Nome_Comprador
        FROM compras c
        JOIN compradores cmpd ON c.Comprador_ID = cmpd.ID
        WHERE cmpd.ID IN (';

        foreach ($ids_compradores as $id) {
            $sql .= $id['ID'];
            if ($id != end($ids_compradores))
                $sql .= ',';
        }

        $sql .= ')';

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->fetchAll();
        
        $qtd_total = count($rs);


        /**
         * COM LIMIT
         */

        $sql = 'SELECT c.*, cmpd.Nome AS Nome_Comprador
        FROM compras c
        JOIN compradores cmpd ON c.Comprador_ID = cmpd.ID
        WHERE cmpd.ID IN (';

        foreach ($ids_compradores as $id) {
            $sql .= $id['ID'];
            if ($id != end($ids_compradores))
                $sql .= ',';
        }

        $sql .= ')';

        // =======================================================
        // Campo de busca
        // =======================================================

        if (!empty($post['search']['value']))
            $sql .= 'AND c.Observacoes LIKE \'%'.strtoupper($post['search']['value']).'%\' ';

        // =======================================================
        // Ordenação
        // =======================================================

        switch ($post['order'][0]['column']) {
            case 0:
                $sql .= 'ORDER BY c.Id '.$post['order'][0]['dir'].' ';
                break;
            case 1:
                $sql .= 'ORDER BY c.Data '.$post['order'][0]['dir'].' ';
                break;
            case 2:
                $sql .= 'ORDER BY c.Observacoes '.$post['order'][0]['dir'].' ';
                break;
            case 3:
                $sql .= 'ORDER BY c.Valor '.$post['order'][0]['dir'].' ';
                break;
            case 4:
                $sql .= 'ORDER BY c.Desconto '.$post['order'][0]['dir'].' ';
                break;
            case 5:
                $sql .= 'ORDER BY c.Forma_Pagamento '.$post['order'][0]['dir'].' ';
                break;
            case 6:
                $sql .= 'ORDER BY c.Comprador_ID '.$post['order'][0]['dir'].' ';
                break;
            
            default:
                # code...
                break;
        }

        // =======================================================
        // Limite e Deslocamento
        // =======================================================

        $sql .= 'LIMIT '.$post['length'].' OFFSET '.$post['start'];

        

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $compras = $stmt->fetchAll();


        /**
         * SEM LIMIT (mas com filtros)
         */

        $sql = 'SELECT c.*, cmpd.Nome AS Nome_Comprador
        FROM compras c
        JOIN compradores cmpd ON c.Comprador_ID = cmpd.ID
        WHERE cmpd.ID IN (';

        foreach ($ids_compradores as $id) {
            $sql .= $id['ID'];
            if ($id != end($ids_compradores))
                $sql .= ',';
        }

        $sql .= ')';

        // =======================================================
        // Campo de busca
        // =======================================================

        if (!empty($post['search']['value']))
            $sql .= 'AND c.Observacoes LIKE \'%'.strtoupper($post['search']['value']).'%\' ';



        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->fetchAll();

        $qtd_filtrada = count($rs);


        
        // =======================================================
        // Cria o JSON
        // =======================================================
        
        $json = '{
            "draw": '.$post['draw'].',
            "recordsTotal": '.$qtd_total.',
            "recordsFiltered": '.$qtd_filtrada.',
            "data": [';

        $total = count($compras);
        $i = 1;
        foreach ($compras as $compra) {

            $json .= '[
                        "'.$compra['Observacoes'].'",
                        "'.$compra['Data'].'",
                        "'.$compra['Id'].'",
                        "'.$compra['Valor'].'",
                        "'.$compra['Desconto'].'",
                        "'.$compra['Forma_Pagamento'].'",
                        "'.$compra['Nome_Comprador'].'"
                    ]';
            if ($i < $total)
                $json .= ',';
            $i++;
        
        }

        $json .= ']}';

        return $json;

    }
    
    
}
