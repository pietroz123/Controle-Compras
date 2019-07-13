<?php

/**
 * Description of CategoriaSubcategoriaDAO
 *
 * @author Pietro
 */
class CategoriaSubcategoriaDAO {
    
    /**
     * Recupera as informações da Categoria a partir de seu ID
     * 
     * @param PDO $dbconn       : Conexão com o BD
     * @param int $id           : ID da Categoria
     * 
     * @return array $categoria : Categoria encontrada
     */
    public static function recuperarCategoria($dbconn, $id) {

        $sql = "SELECT * FROM categorias WHERE ID_Categoria = $id";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $categoria = $stmt->fetch();
        return $categoria;

    }

    /**
     * Recupera as informações da Subcategoria a partir de seu ID
     * 
     * @param PDO $dbconn       : Conexão com o BD
     * @param int $id           : ID da Subcategoria
     * 
     * @return array $subcategoria : Subcategoria encontrada
     */
    public static function recuperarSubcategoria($dbconn, $id) {

        $sql = "SELECT * FROM subcategorias WHERE ID_Subcategoria = $id";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $subcategoria = $stmt->fetch();
        return $subcategoria;

    }

    
}
