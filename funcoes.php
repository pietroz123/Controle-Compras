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

// ==================================================================
// ========================= INSERT =================================
// ==================================================================

function inserir_compra($conexao, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id, $imagem) {
    
    $valor = mysqli_real_escape_string($conexao, $valor);
    $data = mysqli_real_escape_string($conexao, $data);
    $observacoes = mysqli_real_escape_string($conexao, $observacoes);
    $desconto = mysqli_real_escape_string($conexao, $desconto);
    $forma_pagamento = mysqli_real_escape_string($conexao, $forma_pagamento);
    $comprador_id = mysqli_real_escape_string($conexao, $comprador_id);

    $query = "INSERT INTO compras (valor, data, observacoes, desconto, forma_pagamento, comprador_id, imagem) VALUES ({$valor}, '{$data}', '{$observacoes}', {$desconto}, '{$forma_pagamento}', {$comprador_id}, '{$imagem}');";
    return mysqli_query($conexao, $query);
}


// Comprime a imagem
function comprimir($fonte, $destino, $qualidade) {

    $info = getimagesize($fonte);

    if ($info['mime'] == 'image/jpeg') 
        $imagem = imagecreatefromjpeg($fonte);

    elseif ($info['mime'] == 'image/png') 
        $imagem = imagecreatefrompng($fonte);

    imagejpeg($imagem, $destino, $qualidade);

    return $destino;
}


// ==================================================================
// ========================= DELETE =================================
// ==================================================================

function remover_compra($conexao, $id) {

    $id = mysqli_real_escape_string($conexao, $id);
    
    $query = "DELETE FROM compras WHERE Id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}


// ==================================================================
// ========================= UPDATE =================================
// ==================================================================

function alterar_compra($conexao, $id, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id) {

    $id = mysqli_real_escape_string($conexao, $id);
    $valor = mysqli_real_escape_string($conexao, $valor);
    $data = mysqli_real_escape_string($conexao, $data);
    $observacoes = mysqli_real_escape_string($conexao, $observacoes);
    $desconto = mysqli_real_escape_string($conexao, $desconto);
    $forma_pagamento = mysqli_real_escape_string($conexao, $forma_pagamento);
    $comprador_id = mysqli_real_escape_string($conexao, $comprador_id);

    $query = "UPDATE compras SET Valor = {$valor}, Data = '{$data}', Observacoes = '{$observacoes}', Desconto = {$desconto}, Forma_Pagamento = '{$forma_pagamento}', Comprador_ID = {$comprador_id} WHERE Id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}


// ==================================================================
// ========================= SELECT =================================
// ==================================================================

function buscar_compra($conexao, $id) {

    $id = mysqli_real_escape_string($conexao, $id);

    $query = "SELECT * FROM compras WHERE Id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return mysqli_fetch_assoc($resultado);
}

function buscar_comprador($conexao, $id_comprador) {

    $id_comprador = mysqli_real_escape_string($conexao, $id_comprador);

    $query = "SELECT * FROM compradores WHERE Id = {$id_comprador}";
    $resultado = mysqli_query($conexao, $query);
    return mysqli_fetch_assoc($resultado);
}



/*********************** Funções dos compradores ***********************/

function inserir_comprador($conexao, $nome, $cidade, $estado, $endereco, $cep, $cpf, $email, $telefone) {

    $nome = mysqli_real_escape_string($conexao, $nome);
    $cidade = mysqli_real_escape_string($conexao, $cidade);
    $estado = mysqli_real_escape_string($conexao, $estado);
    $endereco = mysqli_real_escape_string($conexao, $endereco);
    $cep = mysqli_real_escape_string($conexao, $cep);
    $cpf = mysqli_real_escape_string($conexao, $cpf);
    $email = mysqli_real_escape_string($conexao, $email);
    $telefone = mysqli_real_escape_string($conexao, $telefone);

    $query = "INSERT INTO compradores (nome, cidade, estado, endereco, cep, cpf, email, telefone) VALUES ('{$nome}', '{$cidade}', '{$estado}', '{$endereco}', '{$cep}', '{$cpf}', '{$email}', '{$telefone}');";
    return mysqli_query($conexao, $query);
}