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

function alterar_compra($conexao, $id, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id) {
    $query = "UPDATE compras SET Valor = {$valor}, Data = '{$data}', Observacoes = '{$observacoes}', Desconto = {$desconto}, Forma_Pagamento = '{$forma_pagamento}', Comprador_ID = {$comprador_id} WHERE Id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}

function buscar_compra($conexao, $id) {
    $query = "SELECT * FROM compras WHERE Id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return mysqli_fetch_assoc($resultado);
}

/*********************** Funções dos compradores ***********************/