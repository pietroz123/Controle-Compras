<?php

// Entrada:    nome do grupo
// Saída:      inserção no banco de dados (tabela grupos)
function inserir_grupo($conexao, $nome_grupo) {
    $sql = "INSERT INTO grupos (nome) VALUES (?)";
    $stmt = mysqli_stmt_init($conexao);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Erro na query
    } else {
        mysqli_bind_param($stmt, "s", $nome_grupo);
        mysqli_stmt_execute($stmt);
        // Sucesso
    }
}

// Entrada:    vetor de usuários
// Saída:      inserção no banco de dados (tabela grupo_usuarios)
function inserir_usuarios_grupo($conexao, $usuarios) {
    foreach ($usuarios as $usuario) {
        $id_grupo = mysqli_stmt_insert_id($stmt);
        $sql = "INSERT INTO grupo_usuarios (id_grupo, username) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conexao);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Erro na query
        } else {
            mysqli_bind_param($stmt, "is", $id_grupo, $usuario);
            mysqli_stmt_execute($stmt);
            // Sucesso
        }
    }
}