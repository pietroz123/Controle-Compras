<?php

/******************************* Funcoes usuarios definitivos *******************************/

// Busca pelo email ou username
function buscar_usuario($dbconn, $email_username) {

    $sql = "SELECT * FROM usuarios WHERE usuario = '{$email_username}' OR email = '{$email_username}';";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $usuario = $stmt->fetch();
    return $usuario;
}

// Busca pelo ID
function buscar_usuario_id($dbconn, $id_usuario) {

    $sql = "SELECT * FROM usuarios WHERE id = {$id_usuario};";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();
    $usuario = $stmt->fetch();
    return $usuario;
}

function criar_usuario($dbconn, $nome, $username, $email, $senha, $nome_icone) {


    // Insere o comprador
    if (!inserir_comprador($dbconn, $nome, $email)) {
        $_SESSION['danger'] = "Erro ao inserir comprador" . $dbconn->errorInfo();
        header("Location: ../index.php");
        die();
    }


    // Insere o usuario
    $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (usuario, email, senha, icone) VALUES ('$username', '$email', '$hash_senha', '$nome_icone');";
    $stmt = $dbconn->prepare($sql);
    return $stmt->execute();
}

// Selecionar tanto as informações da tabela Comprador quanto da tabela Usuário
function join_usuario_comprador($dbconn, $email) {
    $sql = "SELECT * FROM usuarios JOIN compradores ON usuarios.Email = compradores.Email WHERE usuarios.Email = ?";
    
    if (!$stmt = $dbconn->prepare($sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao buscar as informações do usuário.";
        header("Location: ../index.php");
        die();
    } else {
        $stmt->bindParam(1, $email);
        $stmt->execute();

        $usuario = $stmt->fetch();
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
function join_usuario_comprador_username($dbconn, $username) {
    $sql = "SELECT * FROM usuarios JOIN compradores ON usuarios.Email = compradores.Email WHERE usuarios.Usuario = ?";
    
    if (!$stmt = $dbconn->prepare($sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao buscar as informações do usuário.";
        header("Location: ../index.php");
        die();
    } else {
        $stmt->bindParam(1, $username);
        $stmt->execute();

        $usuario = $stmt->fetch();
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
function compras_permitidas($dbconn, $username, $email) {
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
    while ($compra = $stmt->fetch(PDO::FETCH_ASSOC)) {
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

function recuperar_usuarios_temp($dbconn) {

    $sql = "SELECT u.ID AS ID_Usuario, c.Nome, u.Usuario, u.Email, u.Criado_Em
            FROM usuarios AS u
            JOIN compradores AS c
            ON u.Email = c.Email
            WHERE u.autenticado = 0;";

    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $usuarios_temp = array();
    while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($usuarios_temp, $usuario);
    }
    return $usuarios_temp;

}

function buscar_usuario_temp($dbconn, $id) {

    $sql = "SELECT * FROM usuarios WHERE id = {$id};";
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();
    $usuario = $stmt->fetch();
    return $usuario;
}

function adicionar_usuario_definitivo($dbconn, $id) {

    $sql = "UPDATE usuarios SET Autenticado = 1 WHERE id = {$id}";
    $stmt = $dbconn->prepare($sql);
    return $stmt->execute();
}

function remover_usuario_temp($dbconn, $email) {

    // Remove o usuario (Obs: ON DELETE CASCADE remove na tabela `usuarios` também)
    $sql = "DELETE FROM compradores WHERE Email = '{$email}'";
    $stmt = $dbconn->prepare($sql);
    return $stmt->execute();

}