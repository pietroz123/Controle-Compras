<?php

function buscar_usuario($conexao, $email, $senha) {
    $senha_sha1 = sha1($senha);
    $query = "SELECT * FROM usuarios WHERE email = '{$email}' AND senha = '{$senha_sha1}';";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    return $usuario;
}