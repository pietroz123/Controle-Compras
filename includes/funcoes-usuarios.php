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


/**
 * Recupera os IDs dos compradores que estão nos mesmos grupos em que o usuário logado está
 * 
 * @param PDO       $dbconn: Conexão com o BD
 * @param string    $usuario: Username do usuário logado
 * 
 * @return array    $ids: Vetor de IDS dos compradores
 */
function compradores_permitidos($dbconn, $usuario_logado, $id_logado) {

    // Recupera todos os IDs daqueles usuários a partir de seus emails
    $sql = "SELECT cp.ID
    FROM compradores cp
    WHERE cp.Email IN (

        -- Recupera todos os e-mails daqueles usuários a partir de seus usernames
        SELECT u.Email
        FROM usuarios u
        WHERE u.Usuario IN (

            -- Recupera todos os usuários que estão nos grupos em que o usuário logado está E autorizaram
            SELECT DISTINCT gu.Username
            FROM grupo_usuarios gu
            WHERE gu.ID_Grupo IN (

                -- Recupera todos os grupos que um usuário está E autorizou
                SELECT gu.ID_Grupo
                FROM grupo_usuarios gu
                WHERE gu.Username = '$usuario_logado' AND gu.Autorizado = TRUE

            )
            AND gu.Username <> '$usuario_logado' AND gu.Autorizado = TRUE

        )

    )
    OR cp.ID = $id_logado";


    $stmt = $dbconn->prepare($sql);
    $stmt->execute();
    
    $ids = array();
    while ($id = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($ids, $id);
    }
    return $ids;
    
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