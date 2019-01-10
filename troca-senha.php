<?php

    // Inicia a sessao
    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }

    // Verifica se o botão de submit foi pressionado
    if (!isset($_POST['submit-troca-senha'])) {
        $_SESSION['danger'] = "Você não deu submit!";
        header("Location: index.php");
    }
    else {

        // Recupera os dados do formulário POST
        $seletor = $_POST['seletor'];
        $token = $_POST['token'];
        $nova_senha = $_POST['nova_senha'];
        $nova_senha_rep = $_POST['nova_senha_rep'];


        $config = parse_ini_file("../private/config_compras.ini");
        $url = $config['site']


        if (empty($nova_senha) || empty($nova_senha_rep)) {
            $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            $_SESSION['danger'] = "Existem campos em branco";
            header("Location: " . $url);
            die();
        }
        elseif ($nova_senha != $nova_senha_rep) {
            $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            $_SESSION['danger'] = "As senhas não são iguais";
            header("Location: " . $url);
            die();
        }


    }