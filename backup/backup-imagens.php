<?php

    $nomeZip = "backups/backup-imagens-".date("d-m-Y-His").".zip";
    
    $zip = new ZipArchive;
    $zip->open($nomeZip, ZipArchive::CREATE);

    $numFotos = 0;
    foreach ( glob('../img/teste/*.*') as $imgName ) {
        $zip->addFile($imgName);
        $numFotos++;
    }

    $zip->close();

    echo json_encode($numFotos);

    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$nomeZip);
    header('Content-Length: ' . filesize($nomeZip));
    readfile($nomeZip);