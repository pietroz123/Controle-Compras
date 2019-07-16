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
     * Recupera o número total de compras no banco
     * 
     * @param PDO       $dbconn: Conexão com o BD
     * @return int      $nComprasTotal: Número total de compras
     */
    public static function numeroComprasTotal($dbconn) {

        // Recupera o número de compras
        $sql = "SELECT * FROM `compras`";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $nComprasTotal = $stmt->rowCount();

        return $nComprasTotal;

    }

    /**
     * Recupera o número total de compras de um usuário,
     * dado o seu ID de Comprador
     * 
     * @param PDO       $dbconn: Conexão com o BD
     * @param int       $id: ID de Comprador
     * @return int      $nCompras: Número de compras
     */
    public static function numeroCompras($dbconn, $id) {

        // Recupera o número de compras
        $sql = "SELECT * FROM `compras` WHERE `comprador_id` = $id";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $nCompras = $stmt->rowCount();

        return $nCompras;

    }


    // =======================================================
    // Recuperação com JSON para DataTables
    // =======================================================

    /**
     * Recupera as compras de um usuário em formato JSON
     * 
     * @param PDO   $dbconn         : Conexão com o BD
     * @param int   $id_usuario     : ID do Usuário
     * @param array $post           : Requisição POST com todo o cabeçalho do DataTables ServerSide
     */
    function recuperarComprasUsuarioJSON($dbconn, $id_usuario, $post) {

        /**
         * Variáveis de ajuda
         */
        $mainSQL = function($id_usuario) {

            $sql = "SELECT c.*, cmpd.Nome AS Nome_Comprador
            FROM compras c
            JOIN compradores cmpd ON c.Comprador_ID = cmpd.ID
            WHERE cmpd.ID = $id_usuario ";

            return $sql;

        };

        /**
         * Sem nenhum filtro (todas as compras)
         */

        $sql = $mainSQL($id_usuario);

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->fetchAll();
        
        $qtd_total = count($rs);


        /**
         * COM LIMIT
         */

        $sql = $mainSQL($id_usuario);


        // Preenche a SQL de acordo com as variáveis do DataTable Server Side
        $sql .= $this->preencherSQL($post['search']['value'], $post['order'][0]['column'], $post['order'][0]['dir'], $post['length'], $post['start']);
        

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $compras = $stmt->fetchAll();


        /**
         * SEM LIMIT (mas com filtros)
         */

        $sql = $mainSQL($id_usuario);

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
        
        $json = $this->criarJSON($compras, $post['draw'], $qtd_total, $qtd_filtrada);

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

        /**
         * Variáveis de ajuda
         */
        $ids_compradores = GrupoDAO::recuperarCompradoresGrupo($dbconn, $id_grupo);
        $mainSQL = function($ids_compradores) {

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

            return $sql;

        };

        /**
         * Sem nenhum filtro (todas as compras)
         */

        $sql = $mainSQL($ids_compradores);

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->fetchAll();
        
        $qtd_total = count($rs);


        /**
         * COM LIMIT
         */

        $sql = $mainSQL($ids_compradores);


        // Preenche a SQL de acordo com as variáveis do DataTable Server Side
        $sql .= $this->preencherSQL($post['search']['value'], $post['order'][0]['column'], $post['order'][0]['dir'], $post['length'], $post['start']);
        

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $compras = $stmt->fetchAll();


        /**
         * SEM LIMIT (mas com filtros)
         */

        $sql = $mainSQL($ids_compradores);

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
        
        $json = $this->criarJSON($compras, $post['draw'], $qtd_total, $qtd_filtrada);

        return $json;

    }


    /**
     * Recupera as compras da página de busca em formato JSON
     * 
     * @param PDO       $dbconn         : Conexão com o BD
     * @param string    $palavra_chave  : Palavra ou frase chave da busca
     * @param string    $data_range     : Intervalo de data
     * @param int       $id_comprador   : ID do Comprador da requisição
     * @param array     $post           : Requisição POST com todo o cabeçalho do DataTables ServerSide
     * @param int       $flag_soma      : Se 1, calcula apenas a soma dos valores
     */
    function recuperarComprasBuscaJSON($dbconn, $palavra_chave, $data_range, $id_comprador, $post, $flag_soma = 0) {

        /**
         * Separa o intervalo de datas em data de início e fim
         * 
         * OBS: As datas utilizam uma flag que indica se o usuário selecionou apenas um dia (1),
         * ou dois dias, formando assim um intervalo (2), ou nenhuma data (0)
         */
        $datas = $data_range;
        if (!empty($datas)) {

            $datas = explode(' - ', $datas);
            if (count($datas) == 1) {
                $data_inicio = implode('-', array_reverse(explode('/', $datas[0])));
                $data_fim = '';
                $flag_data = 1;
            }
            else {
                $data_inicio = implode('-', array_reverse(explode('/', $datas[0])));
                $data_fim    = implode('-', array_reverse(explode('/', $datas[1])));
                $flag_data = 2;
            }

        }
        else {
            $data_inicio = '';
            $data_fim    = '';
            $flag_data = 0;
        }


        /**
         * Variáveis de ajuda
         */
        $mainSQL = "SELECT c.*, cmpd.Nome AS Nome_Comprador 
        FROM compras AS c 
        JOIN compradores AS cmpd ON c.Comprador_ID = cmpd.ID 
        WHERE observacoes LIKE '%{$palavra_chave}%' ";
        
        // Verifica se tem um intervalo de datas
        if (!empty($data_range)) {

            switch ($flag_data) {
                case 1:
                    $mainSQL .= "AND data = '{$data_inicio}'"; 
                    break;
                
                case 2:
                    $mainSQL .= "AND data >= '{$data_inicio}' AND data <= '{$data_fim}' ";
                    break;
            }

        }
            
        // Preenche com o ID do comprador
        $mainSQL .= "AND Comprador_ID = {$id_comprador} ";


        /**
         * Sem nenhum filtro (todas as compras)
         */

        $sql = $mainSQL;


        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->fetchAll();

        /**
         * Se for para calcular a soma ($flag_soma == 1), apenas calcula a soma e retorna
         */
        if ($flag_soma == 1) {

            $soma = 0;
            foreach ($rs as $compra) {
                $soma += $compra['Valor'];
            }

            return $soma;

        }

        
        $qtd_total = count($rs);


        /**
         * COM LIMIT
         */

        $sql = $mainSQL;
        

        // Preenche a SQL de acordo com as variáveis do DataTable Server Side
        $sql .= $this->preencherSQL($post['search']['value'], $post['order'][0]['column'], $post['order'][0]['dir'], $post['length'], $post['start']);
        

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $compras = $stmt->fetchAll();


        /**
         * SEM LIMIT (mas com filtros)
         */

        $sql = $mainSQL;


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
        
        $json = $this->criarJSON($compras, $post['draw'], $qtd_total, $qtd_filtrada);

        return $json;

    }



    /**
     * Recupera as compras permitidas para um usuário, dado uma palavra/frase chave
     * e uma data de início e fim
     * 
     * @param PDO       $dbconn         : Conexão com o BD
     * @param string    $palavra_chave  : Palavra ou frase chave da busca
     * @param string    $data_range     : Intervalo de data
     * @param int       $id_comprador   : ID do Comprador da requisição
     * @param array     $post           : Requisição POST com todo o cabeçalho do DataTables ServerSide
     * @param int       $flag_soma      : Se 1, calcula apenas a soma dos valores
     */
    function recuperarComprasPermitidasJSON($dbconn, $palavra_chave, $data_range, $post, $flag_soma = 0) {

        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
        include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';

        /**
         * Separa o intervalo de datas em data de início e fim
         * 
         * OBS: As datas utilizam uma flag que indica se o usuário selecionou apenas um dia (1),
         * ou dois dias, formando assim um intervalo (2), ou nenhuma data (0)
         */
        $datas = $data_range;
        if (!empty($datas)) {

            $datas = explode(' - ', $datas);
            if (count($datas) == 1) {
                $data_inicio = implode('-', array_reverse(explode('/', $datas[0])));
                $data_fim = '';
                $flag_data = 1;
            }
            else {
                $data_inicio = implode('-', array_reverse(explode('/', $datas[0])));
                $data_fim    = implode('-', array_reverse(explode('/', $datas[1])));
                $flag_data = 2;
            }

        }
        else {
            $data_inicio = '';
            $data_fim    = '';
            $flag_data = 0;
        }


        /**
         * Variáveis da Sessão
         */
        $username       = $_SESSION['login-username'];
        $email          = $_SESSION['login-email'];
        $id             = $_SESSION['login-id-comprador'];
        $ids_permitidos = compradores_permitidos($dbconn, $username, $id);


        /**
         * Variáveis de ajuda
         */
        // Recupera todas as compras daqueles usuários a partir de seus IDs de comprador
        $mainSQL = "SELECT c.*, cmpd.Nome as Nome_Comprador
        FROM compras c
        
        -- Precisamos também do nome do comprador
        JOIN compradores cmpd on c.Comprador_ID = cmpd.ID
        
        WHERE c.Comprador_ID IN (";
        
        foreach ($ids_permitidos as $id_permitido) {
            $mainSQL .= $id_permitido['ID'];
            if ($id_permitido != end($ids_permitidos))
                $mainSQL .= ',';
        }
        
        $mainSQL .= ")
        AND c.Observacoes LIKE '%{$palavra_chave}%' ";

        // Verifica se tem um intervalo de datas
        if (!empty($data_range)) {

            switch ($flag_data) {
                case 1:
                    $mainSQL .= "AND data = '{$data_inicio}'"; 
                    break;
                
                case 2:
                    $mainSQL .= "AND data >= '{$data_inicio}' AND data <= '{$data_fim}' ";
                    break;
            }

        }


        /**
         * Sem nenhum filtro (todas as compras)
         */

        $sql = $mainSQL;

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rs = $stmt->fetchAll();

        /**
         * Se for para calcular a soma ($flag_soma == 1), apenas calcula a soma e retorna
         */
        if ($flag_soma == 1) {

            $soma = 0;
            foreach ($rs as $compra) {
                $soma += $compra['Valor'];
            }

            return $soma;

        }

        
        $qtd_total = count($rs);


        /**
         * COM LIMIT
         */

        $sql = $mainSQL;
        

        // Preenche a SQL de acordo com as variáveis do DataTable Server Side
        $sql .= $this->preencherSQL($post['search']['value'], $post['order'][0]['column'], $post['order'][0]['dir'], $post['length'], $post['start']);
        

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $compras = $stmt->fetchAll();


        /**
         * SEM LIMIT (mas com filtros)
         */

        $sql = $mainSQL;


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

        $json = $this->criarJSON($compras, $post['draw'], $qtd_total, $qtd_filtrada);

        return $json;

    }


    // =======================================================
    //                       HELPERS
    // =======================================================


    /**
     * Helper para preencher a SQL à partir das outras informações
     * da requisição DataTable Server Side
     * 
     * @return string   $json: JSON criado
     */
    private function preencherSQL($search_value, $order_column, $order_dir, $limit, $offset) {

        $sql = '';

        // =======================================================
        // Campo de busca
        // =======================================================

        if (!empty($search_value))
            $sql .= 'AND c.Observacoes LIKE \'%'.strtoupper($search_value).'%\' ';

        // =======================================================
        // Ordenação
        // =======================================================

        switch ($order_column) {
            case 0:
                $sql .= 'ORDER BY c.Id '.$order_dir.' ';
                break;
            case 1:
                $sql .= 'ORDER BY c.Data '.$order_dir.' ';
                break;
            case 2:
                $sql .= 'ORDER BY c.Observacoes '.$order_dir.' ';
                break;
            case 3:
                $sql .= 'ORDER BY c.Valor '.$order_dir.' ';
                break;
            case 4:
                $sql .= 'ORDER BY c.Desconto '.$order_dir.' ';
                break;
            case 5:
                $sql .= 'ORDER BY c.Forma_Pagamento '.$order_dir.' ';
                break;
            case 6:
                $sql .= 'ORDER BY c.Comprador_ID '.$order_dir.' ';
                break;
            
            default:
                # code...
                break;
        }

        // =======================================================
        // Limite e Deslocamento
        // =======================================================

        $sql .= 'LIMIT '.$limit.' OFFSET '.$offset;

        return $sql;

    }

    /**
     * Helper para criar o JSON à partir dos dados das compras
     * 
     * @return string   $json: JSON criado
     */
    private function criarJSON($compras, $draw, $qtd_total, $qtd_filtrada) {

        $json = '{
            "draw": '.$draw.',
            "recordsTotal": '.$qtd_total.',
            "recordsFiltered": '.$qtd_filtrada.',
            "data": [';

        $total = count($compras);
        $i = 1;
        foreach ($compras as $compra) {

            // Cria o botão de edição
            $btnEdit = "<button type='button' id-compra='".$compra['Id']."' class=' float-effect' id='btn-editar-compra'><i class='fas fa-edit'></i></button>";

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
    
    
}
