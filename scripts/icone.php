<?php

    include $_SERVER['DOCUMENT_ROOT'].'/includes/logica-usuarios.php';

    verifica_usuario();


    if (isset($_GET['icone'])) {

        $nome_icone = $_GET['icone'];
        $icone = "../../private/uploads/user-icons/" . $nome_icone . ".png";
        if (file_exists($icone)) {
            $info = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($info, $icone);
            finfo_close($info);
            header("Content-Type: $mime");
            readfile($icone);
        }

    }