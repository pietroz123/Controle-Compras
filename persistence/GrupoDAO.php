<?php

/**
 * Description of GrupoDAO
 *
 * @author Pietro
 */
class GrupoDAO {
    
    /**
     * Recupera os ids, nomes e emails dos compradores em um grupo
     * 
     * @param PDO $dbconn
     * @param int $id_grupo
     * 
     * @return array $compradores
     */
    public static function recuperarCompradoresGrupo($dbconn, $id_grupo) {

        $sql = "SELECT c.ID, c.Nome, c.Email
            FROM compradores c
            WHERE c.Email IN (
                SELECT u.Email
                FROM usuarios u
                WHERE u.Usuario IN (
                    SELECT gu.Username
                    FROM grupo_usuarios gu
                    WHERE gu.ID_Grupo = $id_grupo
                    AND gu.Autorizado = 1           -- Apenas os que autorizaram
                )
            )";
    
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $compradores = array();
        while ($comprador = $stmt->fetch(PDO::FETCH_ASSOC))
            array_push($compradores, $comprador);
        return $compradores;

    }
    
    
}
