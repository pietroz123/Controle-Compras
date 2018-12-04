<?php

function listar($conexao, $query) {
    $compras = array();
    $resultado = mysqli_query($conexao, $query);
    while ($compra = mysqli_fetch_assoc($resultado)) {
        array_push($compras, $compra);
    }
    return $compras;
}


/*********************** Funções das compras ***********************/

function remover_compra($conexao, $id) {
    $query = "DELETE FROM compras WHERE Id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}

function getCompra($conexao, $id) {
    $query = "SELECT * FROM compras WHERE Id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}

/*********************** Funções dos compradores ***********************/