<?php

    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }

    // Verifica se o botão de submit foi pressionado
    if (!isset($_POST['submit-recuperacao'])) {
        $_SESSION['danger'] = "Você não deu submit!";
        header("Location: index.php");
    }
    else {

        $seletor = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        $url = "http://localhost/compras/create-new-password.php?seletor=" . $seletor . "&token=" . bin2hex($token);

        $expira = date("U") + 1800;     // Uma hora para expirar
        

    }