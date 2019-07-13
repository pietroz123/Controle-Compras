<?php

/**
 * Description of CompradorDAO
 *
 * @author Pietro
 */
class CompradorDAO {
    
    /**
     * Recupera as informações de um Comprador, dado seu ID
     * 
     * @param PDO $dbconn           : Conexão com o BD
     * @param int $id               : ID do Comprador
     * 
     * @return array $comprador     : Comprador encontrado
     */
    public static function recuperarComprador($dbconn, $id) {

        $sql = "SELECT * FROM compradores WHERE ID = $id";
    
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $comprador = $stmt->fetch();
        return $comprador;

    }
    
    
}
