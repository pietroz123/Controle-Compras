<?php

/******************************* Funcoes usuarios definitivos *******************************/

function buscar_usuario($conexao, $email_username) {
    $query = "SELECT * FROM usuarios WHERE usuario = '{$email_username}' OR email = '{$email_username}';";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    return $usuario;
}

function criar_usuario($conexao, $nome, $sobrenome, $username, $email, $senha) {
    $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
    $query = "INSERT INTO usuarios_temp (primeiro_nome, sobrenome, usuario, email, senha) VALUES ('$nome', '$sobrenome', '$username', '$email', '$hash_senha');";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}


/******************************* Funcoes usuarios temporarios *******************************/

function buscar_usuario_temp($conexao, $id) {
    $query = "SELECT * FROM usuarios_temp WHERE id = {$id};";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    return $usuario;
}

function adicionar_usuario_definitivo($conexao, $nome, $sobrenome, $username, $email, $senha) {
    $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
    $query_insert = "INSERT INTO usuarios (primeiro_nome, sobrenome, usuario, email, senha) VALUES ('$nome', '$sobrenome', '$username', '$email', '$hash_senha');";
    $resultado = mysqli_query($conexao, $query_insert);
    return $resultado;
}

function remover_usuario_temp($conexao, $id) {
    $query = "DELETE FROM usuarios_temp WHERE id = {$id};";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}