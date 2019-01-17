<?php

    include 'logica-usuarios.php';

    verifica_usuario();


    if (isset($_GET['imagem'])) {

        $nome_imagem = $_GET['imagem'];
        $imagem = "../private/uploads/compras/" . $nome_imagem;
        if (file_exists($imagem)) {
            $info = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($info, $imagem);
            finfo_close($info);
            header("Content-Type: $mime");
            readfile($imagem);
        }

    }