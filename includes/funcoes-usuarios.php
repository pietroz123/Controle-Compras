<?php

/******************************* Funcoes usuarios definitivos *******************************/

function buscar_usuario($conexao, $email_username) {

    $email_username = mysqli_real_escape_string($conexao, $email_username);

    $query = "SELECT * FROM usuarios WHERE usuario = '{$email_username}' OR email = '{$email_username}';";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    return $usuario;
}

function criar_usuario($conexao, $nome, $sobrenome, $username, $email, $senha) {

    $nome = mysqli_real_escape_string($conexao, $nome);
    $sobrenome = mysqli_real_escape_string($conexao, $sobrenome);
    $username = mysqli_real_escape_string($conexao, $username);
    $email = mysqli_real_escape_string($conexao, $email);
    $senha = mysqli_real_escape_string($conexao, $senha);

    $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
    $query = "INSERT INTO usuarios (primeiro_nome, sobrenome, usuario, email, senha) VALUES ('$nome', '$sobrenome', '$username', '$email', '$hash_senha');";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}


/******************************* Funcoes usuarios temporarios *******************************/

function buscar_usuario_temp($conexao, $id) {

    $id = mysqli_real_escape_string($conexao, $id);

    $query = "SELECT * FROM usuarios WHERE id = {$id};";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    return $usuario;
}

function adicionar_usuario_definitivo($conexao, $id) {

    $id = mysqli_real_escape_string($conexao, $id);

    $query = "UPDATE usuarios SET Autenticado = 1 WHERE id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}