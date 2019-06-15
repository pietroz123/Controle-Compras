<?php

// Seleciona todos os ids dos compradores de todos os grupos em que o usuario esta
function recupera_ids_compradores_grupos($dbconn, $username, $email) {
    
    // Recupera os IDs
    $sql = "SELECT co.ID as Comprador_ID
            FROM compradores co
            WHERE co.Email IN (
                -- Seleciona todos os emails desses usuários
                SELECT u.Email
                FROM usuarios u
                WHERE u.Usuario IN (
                    -- Recupera todos os usuários que compartilham algum grupo comigo (verificando a autorização deles)
                    SELECT DISTINCT gu.Username
                    FROM grupo_usuarios gu
                    WHERE gu.ID_Grupo IN (
                        -- Recupera todos os IDs de Grupos em que estou e autorizei
                        SELECT gu.ID_Grupo
                        FROM grupo_usuarios gu
                        WHERE gu.Username = '$username'
                        AND gu.Autorizado = 1
                    )
                    AND gu.Autorizado = 1
                )
            -- Incluí o próprio usuário
            ) OR co.ID IN (
                SELECT compradores.ID
                FROM usuarios
                JOIN compradores ON usuarios.Email = compradores.Email
                WHERE usuarios.Email = '$email'
            );";

    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $ids = array();
    while ($id = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($ids, $id);
    }
    return $ids;
}

// Seleciona todos os ids dos compradores em um determinado grupo que autorizaram
function recuperar_compradores($dbconn, $id_grupo) {
    
    $sql = "SELECT c.ID, c.Nome
            FROM compradores c
            WHERE c.Email IN (
                SELECT u.Email
                FROM usuarios u
                WHERE u.Usuario IN (
                    SELECT gu.Username
                    FROM grupo_usuarios gu
                    WHERE gu.ID_Grupo = $id_grupo
                    AND gu.Autorizado = 1           -- Apenas os que autorizaram
                )
            )";
    
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $ids = array();
    while ($id = $stmt->fetch(PDO::FETCH_ASSOC))
        array_push($ids, $id);
    return $ids;

}

// Recupera o grupo com determinado ID
function recuperar_grupo($dbconn, $id) {
    $sql = "SELECT * FROM grupos WHERE ID = $id";
    
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $grupo = $stmt->fetch();
    return $grupo;
}

// Recupera todos os grupos aos quais um determinado usuário pertence e autorizou
function recuperar_grupos($dbconn, $usuario) {

    $sql = "SELECT g.*
            FROM grupos g
            JOIN grupo_usuarios gu
            ON g.ID = gu.ID_Grupo
            WHERE gu.Username = '$usuario'
            AND gu.Autorizado = 1";
    
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $grupos = array();
    while ($grupo = $stmt->fetch(PDO::FETCH_ASSOC))
        array_push($grupos, $grupo);
    return $grupos;
}

// Recupera todos os membros de um grupo com determinado ID
function recuperar_membros($dbconn, $id_grupo) {

    $sql = "SELECT c.Nome, u.ID AS ID_Usuario, u.Usuario, gu.Membro_Desde, gu.Admin, gu.Autorizado
            FROM usuarios AS u
            JOIN grupo_usuarios AS gu
            ON u.Usuario = gu.Username
            JOIN compradores AS c
            ON u.Email = c.Email
            WHERE gu.ID_Grupo = $id_grupo";

    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $membros = array();
    while ($membro = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($membros, $membro);
    }
    return $membros;
}

// Remove um grupo, dado seu ID
function remover_grupo($dbconn, $id_grupo) {

    $sql = "DELETE FROM grupos WHERE ID = ?";
    
    $stmt = $dbconn->prepare($sql);

    if (!$stmt = $dbconn->prepare($sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao remover o grupo.";
        header("Location: ../perfil-usuario.php");
        die();
    } else {
        $stmt->bindParam(1, $id_grupo);
        $stmt->execute();
    }
}

// Remove um membro do grupo, dado o Username do Membro e o ID do Grupo
function remover_membro($dbconn, $id_grupo, $username) {

    $sql = "DELETE FROM grupo_usuarios WHERE ID_Grupo = ? AND Username = ?";
    
    if (!$stmt = $dbconn->prepare($sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao remover o membro.";
        header("Location: ../perfil-usuario.php");
        die();
    } else {
        $stmt->bindParam(1, $id_grupo);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }
}

// Adiciona um membro no grupo, dado o Username do Membro e o ID do Grupo
function adicionar_membro($dbconn, $id_grupo, $username) {

    $sql = "INSERT INTO grupo_usuarios (ID_Grupo, Username) VALUES (?, ?)";
    
    if (!$stmt = $dbconn->prepare($sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao remover o membro.";
        header("Location: ../perfil-usuario.php");
        die();
    } else {
        $stmt->bindParam(1, $id_grupo);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }
}

// Verifica se dado usuário é ou não Admin do grupo, dado o ID do Grupo e o Nome do Usuário
function isAdmin($dbconn, $id_grupo, $username) {
    
    $sql = "SELECT Admin FROM grupo_usuarios WHERE ID_Grupo = ? AND Username = ?";
    
    if (!$stmt = $dbconn->prepare($sql)) {
        $_SESSION['danger'] = "Ocorreu um erro ao verificar admin.";
        header("Location: ../perfil-usuario.php");
        die();
    } else {
        $stmt->bindParam(1, $id_grupo);
        $stmt->bindParam(2, $username);
        $stmt->execute();

        $admin = $stmt->fetch();

        if ($admin['Admin'] == 1)
            return true;
        else
            return false;
    }
}



function admins($dbconn, $id_grupo) {
    
    $sql = "SELECT *
            FROM grupo_usuarios gu
            WHERE gu.ID_Grupo = $id_grupo
            AND gu.Admin = 1";
    
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();
    
    $admins = array();
    while ($admin = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($admins, $admin);
    }
    return $admins;
}

// Promove outro ADMIN
// Critério: Membro mais antigo do grupo
function promove_admin($dbconn, $id_grupo) {

    // Verifica se o número atual de Admins é zero
    if ( count(admins($dbconn, $id_grupo)) == 1 ) {

        // Procura membro mais antigo que não é admin
        $sql = "SELECT gu.Username
                    FROM grupo_usuarios gu
                    WHERE gu.ID_Grupo = $id_grupo AND gu.Admin = 0
                    ORDER BY gu.Membro_Desde ASC
                    LIMIT 1";
        
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $membro = $stmt->fetch();
        $membro_username = $membro['Username'];

        // Promove o membro para admin
        $sql = "UPDATE grupo_usuarios gu
                    SET gu.Admin = 1
                    WHERE gu.Username = '$membro_username'";
                    
        $stmt = $dbconn->prepare($sql);
        return $stmt->execute();

    }



}