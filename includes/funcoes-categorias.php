<?php

function recuperar_categorias($conexao) {
    $categorias = array();
    $sql = "SELECT * FROM categorias";
    $resultado = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($resultado) > 0) {
        while ($categoria = mysqli_fetch_assoc($resultado))
            array_push($categorias, $categoria);
    }
    return $categorias;
}

function recuperar_subcategorias($conexao, $id_categoria) {
    $subcategorias = array();
    $sql = "SELECT * FROM subcategorias WHERE ID_Categoria = $id_categoria";
    $resultado = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($resultado) > 0) {
        while ($categoria = mysqli_fetch_assoc($resultado))
            array_push($subcategorias, $categoria);
    }
    return $subcategorias;
}