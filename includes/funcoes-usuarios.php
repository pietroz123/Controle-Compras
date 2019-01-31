<?php

/******************************* Funcoes usuarios definitivos *******************************/

// Busca pelo email ou username
function buscar_usuario($conexao, $email_username) {

    $email_username = mysqli_real_escape_string($conexao, $email_username);

    $query = "SELECT * FROM usuarios WHERE usuario = '{$email_username}' OR email = '{$email_username}';";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    return $usuario;
}

// Busca pelo ID
function buscar_usuario_id($conexao, $id_usuario) {

    $email_username = mysqli_real_escape_string($conexao, $id_usuario);

    $query = "SELECT * FROM usuarios WHERE id = {$id_usuario};";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    return $usuario;
}

function criar_usuario($conexao, $nome, $cpf, $cep, $cidade, $estado, $endereco, $telefone, $username, $email, $senha) {

    $nome = mysqli_real_escape_string($conexao, $nome);
    $cpf = mysqli_real_escape_string($conexao, $cpf);
    $cep = mysqli_real_escape_string($conexao, $cep);
    $cidade = mysqli_real_escape_string($conexao, $cidade);
    $estado = mysqli_real_escape_string($conexao, $estado);
    $endereco = mysqli_real_escape_string($conexao, $endereco);
    $telefone = mysqli_real_escape_string($conexao, $telefone);

    // Insere o comprador
    if (!inserir_comprador($conexao, $nome, $cidade, $estado, $endereco, $cep, $cpf, $email, $telefone)) {
        $_SESSION['danger'] = "Erro ao inserir comprador" . mysqli_error($conexao);
        header("Location: ../index.php");
        die();
    }

    $username = mysqli_real_escape_string($conexao, $username);
    $email = mysqli_real_escape_string($conexao, $email);
    $senha = mysqli_real_escape_string($conexao, $senha);

    // Insere o usuario
    $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
    $query = "INSERT INTO usuarios (usuario, email, senha) VALUES ('$username', '$email', '$hash_senha');";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}

function join_usuario_comprador($conexao, $email) {
    $sql = "SELECT * FROM usuarios JOIN compradores ON usuarios.Email = compradores.Email WHERE usuarios.Email = ?";
    $stmt = mysqli_stmt_init($conexao);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao buscar as informações do usuário.";
        header("Location: ../index.php");
        die();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultado = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($resultado);
        if ($usuario == null) {
            $_SESSION['danger'] = "Usuário inexistente.";
            header("Location: ../index.php");
            die();
        }
        else {
            return $usuario;
        }
    }
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