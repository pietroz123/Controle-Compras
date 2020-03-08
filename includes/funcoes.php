<?php

// Retorna um vetor do resultado da SQL especificada no parâmetro
function listar($dbconn, $sql) {

    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $lista = array();
    while ($item = $stmt->fetch(PDO::FETCH_ASSOC))
        array_push($lista, $item);
    return $lista;

}


/*********************** Funções das compras ***********************/

// ==================================================================
// ========================= INSERT =================================
// ==================================================================

function inserir_compra($dbconn, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id, $imagem, $categoria, $subcategorias) {
    
    // Insere a compra
    $sql = "INSERT INTO compras (valor, data, observacoes, desconto, forma_pagamento, comprador_id, imagem, id_categoria) VALUES ({$valor}, '{$data}', '{$observacoes}', {$desconto}, '{$forma_pagamento}', {$comprador_id}, '{$imagem}', $categoria);";
    $stmt = $dbconn->prepare($sql);

    if ($stmt->execute()) {

        // Recupera o id da compra inserida
        $id_compra = $dbconn->lastInsertId();

        // Se existirem subcategorias, insere
        if ($subcategorias) {

            foreach ($subcategorias as $subcategoria) {
                $sql = "INSERT INTO compra_cat_subcat (ID_Compra, ID_Categoria, ID_Subcategoria) VALUES ($id_compra, $categoria, $subcategoria);";
                $stmt = $dbconn->prepare($sql);
                $resultado = $stmt->execute();
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

function remover_compra($dbconn, $id) {

    
    $sql = "DELETE FROM compras WHERE Id = {$id}";
    $stmt = $dbconn->prepare($sql);
    $resultado = $stmt->execute();
    return $resultado;
}


// ==================================================================
// ========================= UPDATE =================================
// ==================================================================

function alterar_compra($dbconn, $id, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id) {


    $sql = "UPDATE compras SET Valor = {$valor}, Data = '{$data}', Observacoes = '{$observacoes}', Desconto = {$desconto}, Forma_Pagamento = '{$forma_pagamento}', Comprador_ID = {$comprador_id} WHERE Id = {$id}";
    $stmt = $dbconn->prepare($sql);
    $resultado = $stmt->execute();
    return $resultado;
}


// ==================================================================
// ========================= SELECT =================================
// ==================================================================

function recuperar_compras($dbconn, $id_comprador) {
    $sql = "SELECT cmp.*, cmpd.Nome AS Nome_Comprador
            FROM compras cmp
            JOIN compradores cmpd ON cmp.Comprador_ID = cmpd.ID
            WHERE cmpd.ID = $id_comprador
            ORDER BY year(data), month(data), day(data)";
    
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $compras = array();
    while ($compra = $stmt->fetch(PDO::FETCH_ASSOC))
        array_push($compras, $compra);
    return $compras;
}

// Retorna as informações de uma compra, dado seu ID
function buscar_compra($dbconn, $id) {

    $sql = "SELECT * FROM compras WHERE Id = {$id}";

    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $compra = $stmt->fetch();
    return $compra;
}


// Recupera as informações do comprador, dado seu ID
function buscar_comprador($dbconn, $id_comprador) {

    $sql = "SELECT * FROM compradores WHERE Id = {$id_comprador}";

    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $comprador = $stmt->fetch();
    return $comprador;

}



/*********************** Funções dos compradores ***********************/

function inserir_comprador($dbconn, $nome, $email) {

    $sql = "INSERT INTO compradores (nome, email) VALUES ('{$nome}', '{$email}');";
    $stmt = $dbconn->prepare($sql);
    return $stmt->execute();
}