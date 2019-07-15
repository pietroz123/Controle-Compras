<?php

/**
 * Description of IndexDAO
 *
 * @author Pietro
 */
class IndexDAO {


    // =======================================================
    // Nível: Administrador
    // =======================================================
    
    /**
     * Recupera o número total de usuários no banco
     * 
     * @param PDO       $dbconn: Conexão com o BD
     * @return int      $nUsuariosTotal: Número total de usuários
     */
    public static function numeroUsuariosTotal($dbconn) {

        // Recupera o número de usuários
        $sql = "SELECT * FROM `usuarios`";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $nUsuariosTotal = $stmt->rowCount();

        return $nUsuariosTotal;
       
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
     * Recupera o número total de grupos no banco
     * 
     * @param PDO       $dbconn: Conexão com o BD
     * @return int      $nGruposTotal: Número total de grupos
     */
    public static function numeroGruposTotal($dbconn) {

        // Recupera o número de grupos
        $sql = "SELECT * FROM `grupos`";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $nGruposTotal = $stmt->rowCount();

        return $nGruposTotal;

    }

    /**
     * Recupera o número total de requisições no banco
     * 
     * @param PDO       $dbconn: Conexão com o BD
     * @return int      $nRequisicoes: Número total de requisições
     */
    public static function numeroRequisicoes($dbconn) {

        // Recupera o número de usuários não autenticados
        $sql = "SELECT * FROM `usuarios` WHERE `Autenticado` = 0";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $nRequisicoes = $stmt->rowCount();

        return $nRequisicoes;

    }

    /**
     * Recupera as tabelas disponíveis para backup no banco
     * 
     * @param PDO       $dbconn: Conexão com o BD
     * @return array    $tabelas: Tabelas disponíveis
     */
    public static function recuperarTabelas($dbconn) {

        $sql = "SHOW TABLES";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $tabelas = array();
        while ($tabela = $stmt->fetch(PDO::FETCH_ASSOC))
            array_push($tabelas, $tabela);

        return $tabelas;

    }


    // =======================================================
    // Nível: Usuário
    // =======================================================

    /**
     * Recupera o número total de grupos em que um usuário está autorizado, dado
     * seu nome de usuário
     * 
     * @param PDO       $dbconn: Conexão com o BD
     * @param string    $username: Nome de usuário
     * @return int      $nGrupos: Número de grupos
     */
    public static function numeroGrupos($dbconn, $username) {

        // Recupera o número de grupos do usuário
        $sql = "SELECT * FROM grupo_usuarios gu WHERE gu.Username = '$username' AND gu.Autorizado = TRUE";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $nGrupos = $stmt->rowCount();

        return $nGrupos;

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
    
    
}
