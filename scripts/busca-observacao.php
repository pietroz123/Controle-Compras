<?php


function grupos($conexao, $username) {
    $grupos = "SELECT gu.ID_Grupo
        FROM grupo_usuarios gu
        WHERE gu.Username = '{$username}'";
    $resultado = mysqli_query($conexao, $grupos);
    if (mysqli_num_rows($resultado) > 0) {
        $ids_grupos_usuario = array();
        while ($id_grupo_usuario = mysqli_fetch_assoc($resultado)) {
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

function usuarios($conexao, $username, $string_ids_grupos) {
    $grupo_usuarios = "SELECT DISTINCT gu.Username
                FROM grupo_usuarios gu
                WHERE (".$string_ids_grupos.")";
    $resultado = mysqli_query($conexao, $grupo_usuarios);
    $usuarios = array();
    while ($usuario = mysqli_fetch_assoc($resultado)) {
        array_push($usuarios, $usuario);
    }
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


    if (isset($_POST['busca']) && $_POST['busca'] == 'sim') {

        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';

        $observacao = strip_tags($_POST['texto']);

        // Seleciona todos os grupos do usuario admin
        $ids_grupos_usuario = grupos($conexao, $_SESSION['login-username']);
        if ($ids_grupos_usuario != null) {

            $string_ids_grupos = string_or_grupos($ids_grupos_usuario);

            // Seleciona todos os usuarios pertencentes a esses grupos
            $usuarios = usuarios($conexao, $_SESSION['login-username'], $string_ids_grupos);

            $string_usuarios = string_or_usuarios($usuarios);

            $sql = "SELECT DISTINCT `Observacoes` FROM `compras` c WHERE `Observacoes` LIKE ? AND c.Comprador_ID IN (
                        SELECT c.ID
                        FROM compradores c
                        JOIN usuarios u on c.Email = u.Email
                        WHERE ".$string_usuarios."
                    )";
        }
        else {
            $sql = "SELECT DISTINCT `Observacoes` FROM `compras` c WHERE `Observacoes` LIKE ? AND c.Comprador_ID IN (
                        SELECT c.ID
                        FROM compradores c
                        JOIN usuarios u on c.Email = u.Email
                        WHERE u.Usuario = '{$_SESSION['login-username']}'
                    )";
        }

        $stmt = mysqli_stmt_init($conexao);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // Erro
        
        } else {
            $observacao = '%'.$observacao.'%';
            mysqli_stmt_bind_param($stmt, "s", $observacao);
            mysqli_stmt_execute($stmt);

            $retorno = array();
            $resultado = mysqli_stmt_get_result($stmt);

            $i = 0;
            while ($observacao = mysqli_fetch_assoc($resultado)) {
                $retorno[] = array(
                    'id'    => $i,
                    'text'  => $observacao['Observacoes']
                );
                $i++;
            }

            echo json_encode($retorno);
        }

    }