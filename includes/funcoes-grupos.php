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
    $sql = "SELECT c.Nome, u.ID AS ID_Usuario, u.Usuario, gu.Membro_Desde, gu.Admin
            FROM usuarios AS u
            JOIN grupo_usuarios AS gu
            ON u.Usuario = gu.Username
            JOIN compradores AS c
            ON u.Email = c.Email
            WHERE gu.ID_Grupo = $id_grupo";

    $membros = array();
    $resultado = mysqli_query($conexao, $sql);
    while ($membro = mysqli_fetch_assoc($resultado)) {
        array_push($membros, $membro);
    }
    return $membros;
}

// Remove um grupo, dado seu ID
function remover_grupo($conexao, $id_grupo) {
    $sql = "DELETE FROM grupos WHERE ID = ?";
    $stmt = mysqli_stmt_init($conexao);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao remover o grupo.";
        header("Location: ../perfil-usuario.php");
        die();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id_grupo);
        mysqli_stmt_execute($stmt);
    }
}

// Remove um membro do grupo, dado o Username do Membro e o ID do Grupo
function remover_membro($conexao, $id_grupo, $username) {
    $sql = "DELETE FROM grupo_usuarios WHERE ID_Grupo = ? AND Username = ?";
    $stmt = mysqli_stmt_init($conexao);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao remover o membro.";
        header("Location: ../perfil-usuario.php");
        die();
    } else {
        mysqli_stmt_bind_param($stmt, "is", $id_grupo, $username);
        mysqli_stmt_execute($stmt);
    }
}

// Adiciona um membro no grupo, dado o Username do Membro e o ID do Grupo
function adicionar_membro($conexao, $id_grupo, $username) {
    $sql = "INSERT INTO grupo_usuarios (ID_Grupo, Username) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conexao);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao remover o membro.";
        header("Location: ../perfil-usuario.php");
        die();
    } else {
        mysqli_stmt_bind_param($stmt, "is", $id_grupo, $username);
        mysqli_stmt_execute($stmt);
    }
}

// Verifica se dado usuário é ou não Admin do grupo, dado o ID do Grupo e o Nome do Usuário
function isAdmin($conexao, $id_grupo, $username) {
    $sql = "SELECT Admin FROM grupo_usuarios WHERE ID_Grupo = ? AND Username = ?";
    $stmt = mysqli_stmt_init($conexao);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao verificar admin.";
        header("Location: ../perfil-usuario.php");
        die();
    } else {
        mysqli_stmt_bind_param($stmt, "is", $id_grupo, $username);
        mysqli_stmt_execute($stmt);

        $resultado = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($resultado);

        if ($admin['Admin'] == 1)
            return true;
        else
            return false;
    }
}