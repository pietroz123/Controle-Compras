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

    $id_usuario = mysqli_real_escape_string($conexao, $id_usuario);

    $query = "SELECT * FROM usuarios WHERE id = {$id_usuario};";
    $resultado = mysqli_query($conexao, $query);
    $usuario = mysqli_fetch_assoc($resultado);
    return $usuario;
}

function criar_usuario($conexao, $nome, $username, $email, $senha, $nome_icone) {

    $nome = mysqli_real_escape_string($conexao, $nome);

    // Insere o comprador
    if (!inserir_comprador($conexao, $nome, $email)) {
        $_SESSION['danger'] = "Erro ao inserir comprador" . mysqli_error($conexao);
        header("Location: ../index.php");
        die();
    }

    $username = mysqli_real_escape_string($conexao, $username);
    $email = mysqli_real_escape_string($conexao, $email);
    $senha = mysqli_real_escape_string($conexao, $senha);
    $nome_icone = mysqli_real_escape_string($conexao, $nome_icone);

    // Insere o usuario
    $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
    $query = "INSERT INTO usuarios (usuario, email, senha, icone) VALUES ('$username', '$email', '$hash_senha', '$nome_icone');";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;
}

// Selecionar tanto as informações da tabela Comprador quanto da tabela Usuário
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
function join_usuario_comprador_username($conexao, $username) {
    $sql = "SELECT * FROM usuarios JOIN compradores ON usuarios.Email = compradores.Email WHERE usuarios.Usuario = ?";
    $stmt = mysqli_stmt_init($conexao);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao buscar as informações do usuário.";
        header("Location: ../index.php");
        die();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $username);
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

// Seleciona todas as compras dos usuarios que tem os IDs permitidos ORDENADO por Data
function compras_permitidas($conexao, $username, $email) {
    $sql = "SELECT cmp.*, cmpd.Nome AS Nome_Comprador
            FROM compras AS cmp
            JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID
            WHERE cmpd.ID IN (
                SELECT DISTINCT cmp.Comprador_ID
                FROM compras AS cmp
                JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID
                WHERE cmp.Comprador_ID IN (
                    SELECT DISTINCT c.ID AS Comprador_ID
                    FROM grupo_usuarios gu
                    JOIN usuarios u on gu.Username = u.Usuario
                    JOIN compradores c on u.Email = c.Email
                    WHERE gu.ID_Grupo IN (
                        SELECT gu.ID_Grupo
                        FROM grupo_usuarios gu
                        JOIN usuarios u on gu.Username = u.Usuario
                        WHERE u.Usuario = '$username'
                    )
                ) OR cmp.Comprador_ID IN (
                    SELECT compradores.ID
                    FROM usuarios
                    JOIN compradores ON usuarios.Email = compradores.Email
                    WHERE usuarios.Email = '$email'
                )
            )
            ORDER BY year(data), month(data), day(data);";
    
    $compras = array();
    $resultado = mysqli_query($conexao, $sql);
    while ($compra = mysqli_fetch_assoc($resultado)) {
        array_push($compras, $compra);
    }
    return $compras;
}

function compras_permitidas_like($dbconn, $username, $email, $palavra_chave, $dataInicio, $dataFim) {

    $sql = "SELECT cmp.*, cmpd.Nome AS Nome_Comprador
            FROM compras AS cmp
            JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID
            WHERE cmpd.ID IN (
                SELECT DISTINCT cmp.Comprador_ID
                FROM compras AS cmp
                JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID
                WHERE cmp.Comprador_ID IN (
                    SELECT DISTINCT c.ID AS Comprador_ID
                    FROM grupo_usuarios gu
                    JOIN usuarios u on gu.Username = u.Usuario
                    JOIN compradores c on u.Email = c.Email
                    WHERE gu.ID_Grupo IN (
                        SELECT gu.ID_Grupo
                        FROM grupo_usuarios gu
                        JOIN usuarios u on gu.Username = u.Usuario
                        WHERE u.Usuario = '$username'
                    )
                ) OR cmp.Comprador_ID IN (
                    SELECT compradores.ID
                    FROM usuarios
                    JOIN compradores ON usuarios.Email = compradores.Email
                    WHERE usuarios.Email = '$email'
                )
            )
            AND cmp.Observacoes LIKE '%".$palavra_chave."%'";

    // Caso tenha sido selecionado um range de datas
    if (!empty($dataInicio) && !empty($dataFim))
        $sql .= "AND data >= '{$dataInicio}' AND data <= '{$dataFim}'";
        
    // Completa a SQL com ordenação
    $sql .= "ORDER BY year(data), month(data), day(data) DESC;";

    $stmt = $dbconn->prepare($sql);
    $stmt->execute();
    
    $compras = array();
    while ($compra = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($compras, $compra);
    }
    return $compras;
}


/******************************* Funcoes usuarios temporarios *******************************/

function recuperar_usuarios_temp($conexao) {

    $sql = "SELECT u.ID AS ID_Usuario, c.Nome, u.Usuario, u.Email, u.Criado_Em
            FROM usuarios AS u
            JOIN compradores AS c
            ON u.Email = c.Email
            WHERE u.autenticado = 0;";

    $usuarios_temp = array();
    $resultado = mysqli_query($conexao, $sql);
    while ($usuario = mysqli_fetch_assoc($resultado)) {
        array_push($usuarios_temp, $usuario);
    }
    return $usuarios_temp;

}

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

function remover_usuario_temp($conexao, $email) {

    $email = mysqli_real_escape_string($conexao, $email);
    
    // Remove o usuario (Obs: ON DELETE CASCADE remove na tabela `usuarios` também)
    $query = "DELETE FROM compradores WHERE Email = '{$email}'";
    $resultado = mysqli_query($conexao, $query);
    return $resultado;

}