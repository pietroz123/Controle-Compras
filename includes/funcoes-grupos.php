<?php

// Recupera o grupo com determinado ID
function recuperar_grupo($conexao, $id) {
    $sql = "SELECT * FROM grupos WHERE ID = $id";
    $resultado = mysqli_query($conexao, $sql);
    $grupo = mysqli_fetch_assoc($resultado);
    return $grupo;
}

// Recupera todos os grupos aos quais um determinado usuário pertence
function recuperar_grupos($conexao, $usuario) {
    $sql = "SELECT grupos.*
            FROM grupos
            JOIN grupo_usuarios
            ON grupos.ID = grupo_usuarios.ID_Grupo
            WHERE grupo_usuarios.Username = '$usuario'";
    
    $grupos = array();
    $resultado = mysqli_query($conexao, $sql);
    while ($grupo = mysqli_fetch_assoc($resultado)) {
        array_push($grupos, $grupo);
    }
    return $grupos;
}

// Recupera todos os membros de um grupo com determinado ID
function recuperar_membros($conexao, $id_grupo) {
    $sql = "SELECT *
            FROM usuarios
            JOIN grupo_usuarios
            ON usuarios.Usuario = grupo_usuarios.Username
            JOIN compradores
            ON usuarios.Email = compradores.Email
            WHERE grupo_usuarios.ID_Grupo = $id_grupo";

    $membros = array();
    $resultado = mysqli_query($conexao, $sql);
    while ($membro = mysqli_fetch_assoc($resultado)) {
        array_push($membros, $membro);
    }
    return $membros;
}