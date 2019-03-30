<?php

if ( isset($_POST['submit-download']) && isset($_POST['nome-arquivo']) ) {

    $nome_arquivo   = $_POST['nome-arquivo'];
    $nome_real      = "../../private/backups/banco/".$nome_arquivo;

    $tipo = filetype($nome_real);

    // Executa o Download do arquivo
    header("Pragma: public", true);
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename=".basename($nome_real));
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($nome_real));
    die(file_get_contents($nome_real));
    
}