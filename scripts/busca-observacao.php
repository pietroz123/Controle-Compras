<?php

include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';


// =======================================================
// Funções auxiliares
// =======================================================

function grupos($dbconn, $username) {

    $sql = "SELECT gu.ID_Grupo
        FROM grupo_usuarios gu
        WHERE gu.Username = '{$username}'";

    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $ids_grupos_usuario = array();
        while ($id_grupo_usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($ids_grupos_usuario, $id_grupo_usuario);
        }
        return $ids_grupos_usuario;
    }
    else
        return null;

}

function string_or_grupos($ids_grupos_usuario) {
    $string_ids_grupos = "";
    foreach ($ids_grupos_usuario as $id_grupo_usuario) {
        if ($id_grupo_usuario != end($ids_grupos_usuario))
            $string_ids_grupos .= "gu.ID_Grupo = " . $id_grupo_usuario['ID_Grupo'] . " OR ";
        else
            $string_ids_grupos .= "gu.ID_Grupo = " . $id_grupo_usuario['ID_Grupo'];
    }
    return $string_ids_grupos;
}

function usuarios($dbconn, $username, $string_ids_grupos) {

    $sql = "SELECT DISTINCT gu.Username
                FROM grupo_usuarios gu
                WHERE (".$string_ids_grupos.")";
    
    $stmt = $dbconn->prepare($sql);
    $stmt->execute();

    $usuarios = array();
    while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC))
        array_push($usuarios, $usuario);
    return $usuarios;

}

function string_or_usuarios($usuarios) {
    $string_usuarios = "";
    foreach ($usuarios as $usuario) {
        if ($usuario != end($usuarios))
            $string_usuarios .= "u.Usuario = '" . $usuario['Username'] . "' OR ";
        else
            $string_usuarios .= "u.Usuario = '" . $usuario['Username'] . "'";
    }
    return $string_usuarios;
}


// =======================================================
// Trata a requisição POST
// =======================================================

if (isset($_POST['busca']) && $_POST['busca'] == 'sim') {


    $observacao = strip_tags($_POST['texto']);

    // Seleciona todos os grupos do usuario admin
    $ids_grupos_usuario = grupos($dbconn, $_SESSION['login-username']);
    if ($ids_grupos_usuario != null) {

        $string_ids_grupos = string_or_grupos($ids_grupos_usuario);

        // Seleciona todos os usuarios pertencentes a esses grupos
        $usuarios = usuarios($dbconn, $_SESSION['login-username'], $string_ids_grupos);

        $string_usuarios = string_or_usuarios($usuarios);

        $sql = "SELECT DISTINCT c.Observacoes FROM compras c WHERE c.Observacoes LIKE ? AND c.Comprador_ID IN (
                    SELECT c.ID
                    FROM compradores c
                    JOIN usuarios u on c.Email = u.Email
                    WHERE ".$string_usuarios."
                )";
    }
    else {
        $sql = "SELECT DISTINCT c.Observacoes FROM compras c WHERE c.Observacoes LIKE ? AND c.Comprador_ID IN (
                    SELECT c.ID
                    FROM compradores c
                    JOIN usuarios u on c.Email = u.Email
                    WHERE u.Usuario = '{$_SESSION['login-username']}'
                )";
    }

    
    if (!($stmt = $dbconn->prepare($sql))) {
        // Erro
    
    } else {
        $observacao = '%'.$observacao.'%';
        $stmt->bindParam(1, $observacao);
        $stmt->execute();

        $retorno = array();
        while ($compra = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($retorno, $compra['Observacoes']);
        }

        echo json_encode($retorno);
    }

}