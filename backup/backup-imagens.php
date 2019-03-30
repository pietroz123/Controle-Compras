<?php

if ( isset($_POST['submit-download-imagens']) ) {

    date_default_timezone_set('America/Sao_Paulo');
    $nomeZip = "backup-imagens-".date("d-m-Y-His").".zip";
    
    $zip = new ZipArchive;
    $tmp = tempnam('.', '');
    $zip->open($tmp, ZipArchive::CREATE);
    
    $numFotos = 0;
    foreach ( glob('../../private/uploads/compras/*.*') as $imgName ) {
        $download = file_get_contents($imgName);
        $zip->addFromString(basename($imgName), $download);
        $numFotos++;
    }
    
    $zip->close();
    
    # send the file to the browser as a download
    header('Content-disposition: attachment; filename='.$nomeZip);
    header('Content-type: application/zip');
    readfile($tmp);

}