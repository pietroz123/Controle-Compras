<?php

if ( (isset($_POST['remover']) && $_POST['remover'] == "sim") && isset($_POST['nome_arquivo']) ) {

    $nome_arquivo = "backups/" . $_POST['nome_arquivo'];

    // Remove o arquivo com 'unlink()'
    if (unlink($nome_arquivo)) {
        echo true;
    }
    else {
        echo false;
    }

}