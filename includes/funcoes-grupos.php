<?php

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