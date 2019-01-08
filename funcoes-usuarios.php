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
    $query = "INSERT INTO usuarios (primeiro_nome, sobrenome, usuario, email, senha) VALUES ('$nome', '$sobrenome', '$username', '$email', '$hash_senha');";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}


/******************************* Funcoes usuarios temporarios *******************************/

function buscar_usuario_temp($conexao, $id) {
    $query = "SELECT * FROM usuarios WHERE id = {$id};";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    return $usuario;
}

function adicionar_usuario_definitivo($conexao, $id) {
    $query = "UPDATE usuarios SET Autenticado = 1 WHERE id = {$id}";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}

// !NAO FUNCIONA
function enviar_email($email_usuario) {

    $email_de = "pietrozuntini@gmail.com";
    $email_para = $email_usuario;
    $headers = "From: " . $email_de;
    $assunto = "Autorizacao Compras";
    $mensagem = "Voce esta autorizado! :)";

    mail($email_para, $assunto, $mensagem, $headers);
}