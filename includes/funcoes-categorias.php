<?php

// Recupera todas as categorias
function recuperar_categorias($dbconn) {

    $sql = "SELECT * FROM categorias";
    $categorias = array();

    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($categoria = $stmt->fetch(PDO::FETCH_ASSOC))
            array_push($categorias, $categoria);
    }
    return $categorias;

}

// Recupera todas as subcategorias de uma categoria
function recuperar_subcategorias($dbconn, $id_categoria) {

    $sql = "SELECT * FROM subcategorias WHERE ID_Categoria = $id_categoria";
    $subcategorias = array();
    
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        while ($subcategoria = $stmt->fetch(PDO::FETCH_ASSOC))
            array_push($subcategorias, $subcategoria);
    }
    return $subcategorias;

}