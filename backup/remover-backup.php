<?php

if ( (isset($_POST['remover']) && $_POST['remover'] == "sim") && isset($_POST['nome_arquivo']) ) {

    $nome_arquivo = "../../private/backups/banco/" . $_POST['nome_arquivo'];

    // Remove o arquivo com 'unlink()'
    if (unlink($nome_arquivo)) {
        echo json_encode(true);
    }
    else {
        echo json_encode(false);
    }

}