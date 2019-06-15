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

function inserir_compra($conexao, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id, $imagem, $categoria, $subcategorias) {
    
    $valor = mysqli_real_escape_string($conexao, $valor);
    $data = mysqli_real_escape_string($conexao, $data);
    $observacoes = mysqli_real_escape_string($conexao, $observacoes);
    $desconto = mysqli_real_escape_string($conexao, $desconto);
    $forma_pagamento = mysqli_real_escape_string($conexao, $forma_pagamento);
    $comprador_id = mysqli_real_escape_string($conexao, $comprador_id);
    $imagem = mysqli_real_escape_string($conexao, $imagem);

    // Insere a compra
    $query = "INSERT INTO compras (valor, data, observacoes, desconto, forma_pagamento, comprador_id, imagem) VALUES ({$valor}, '{$data}', '{$observacoes}', {$desconto}, '{$forma_pagamento}', {$comprador_id}, '{$imagem}');";
    $resultado = mysqli_query($conexao, $query);
    if ($resultado) {

        // Se existir uma categoria
        if (!empty($categoria)) {

            // Insere as categorias e subcategorias
            $id_compra = mysqli_insert_id($conexao);
            $sql = "INSERT INTO compra_categorias (ID_Compra, ID_Categoria) VALUES ($id_compra, $categoria);";
            if (mysqli_query($conexao, $sql)) {

                // Se existirem subcategorias
                if (!empty($subcategorias)) {

                    foreach ($subcategorias as $subcategoria) {
                        $sql = "INSERT INTO compra_cat_subcat (ID_Compra, ID_Categoria, ID_Subcategoria) VALUES ($id_compra, $categoria, $subcategoria);";
                        $resultado = mysqli_query($conexao, $sql);
                        if ($resultado)
                            continue;   
                        else
                            return false;
                    }
                    if ($resultado)
                        return true;
                    else
                        return false;

                }
            }

        }
        return true;
    }
    else
        return false;
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

function recuperar_compras($conexao, $id_comprador) {
    $sql = "SELECT cmp.*, cmpd.Nome AS Nome_Comprador
            FROM compras cmp
            JOIN compradores cmpd ON cmp.Comprador_ID = cmpd.ID
            WHERE cmpd.ID = $id_comprador
            ORDER BY year(data), month(data), day(data)";
    
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $compras = array();
    while ($compra = $stmt->fetch(PDO::FETCH_ASSOC))
        array_push($compras, $compra);
    return $compras;
}

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

function inserir_comprador($conexao, $nome, $email) {

    $nome = mysqli_real_escape_string($conexao, $nome);
    $email = mysqli_real_escape_string($conexao, $email);

    $query = "INSERT INTO compradores (nome, email) VALUES ('{$nome}', '{$email}');";
    return mysqli_query($conexao, $query);
}