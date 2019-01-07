<?php

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