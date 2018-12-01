<?php

function listar($conexao, $query) {
    $compras = array();
    $resultado = mysqli_query($conexao, $query);
    while ($compra = mysqli_fetch_assoc($resultado)) {
        array_push($compras, $compra);
    }
    return $compras;
}

function remover_compra($conexao, $id) {
    $query = "delete from compras where Id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}