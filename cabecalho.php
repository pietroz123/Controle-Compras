<?php
    ob_start();
    date_default_timezone_set('America/Sao_Paulo');
    include $_SERVER['DOCUMENT_ROOT'].'/includes/logica-usuarios.php';
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <title>Minhas Compras</title>
        <meta charset="utf-8">
        
        <!-- CSSs -->
        <link rel="shortcut icon" href="img/shopping.png" type="image/x-icon">
        <link type="text/css" href="css/bootstrap4.css" rel="stylesheet">
        <link type="text/css" href="css/mdb.css" rel="stylesheet">
        <link type="text/css" href="css/datatables.css" rel="stylesheet">
        <link type="text/css" href="css/awesomplete.css" rel="stylesheet">
        <link type="text/css" href="css/select2.css" rel="stylesheet">
        <link type="text/css" href="css/bounce-arrow.css" rel="stylesheet">
        <link type="text/css" href="css/cropper.css" rel="stylesheet">
        
        <link type="text/css" href="css/compras.css" rel="stylesheet">
        <link type="text/css" href="css/design-responsivo.css" rel="stylesheet">
        
        <!-- Viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        
        <!-- Fontes de Texto -->
        <link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">

        <!-- Icones -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    </head>

    <body>

        <!-- Modal de Login e Cadastro -->
        <?php
            if (!usuario_esta_logado()) {
                include 'modal-login.php';
            }
        ?>

        <!-- Menu de navegação: no Bootstrap é a classe navbar -->
        <!-- https://www.youtube.com/watch?v=23bpce-5s8I -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" id="barra-navegacao">
                
            <div class="container">
                <div class="navbar-header">
                    <?php
                        if (usuario_esta_logado()) {
                    ?>
                        <a href="perfil-usuario.php" id="icone-usuario">
                            <span class="rounded-circle">
                                <img src="scripts/icone.php?icone=<?= $_SESSION['login-username']; ?>" class="imagem-usuario">
                            </span>
                        </a>
                    <?php
                        }
                    ?>
                    <a class="navbar-brand" href="index.php"><strong>Home</strong></a>
                </div>
                
                <button class="navbar-toggler">
                    <span class="navbar-toggler-icon" data-toggle="collapse" data-target="#navbarMenu"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarMenu">
                    <?php
                        if (usuario_esta_logado()) {
                    ?>
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" onmouseover="this.classList.add('nav-hover-bg')" onmouseout="this.classList.remove('nav-hover-bg')" href="formulario-compra.php">Adicionar Compra</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onmouseover="this.classList.add('nav-hover-bg')" onmouseout="this.classList.remove('nav-hover-bg')" href="listar-compras.php">Compras</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onmouseover="this.classList.add('nav-hover-bg')" onmouseout="this.classList.remove('nav-hover-bg')" href="buscar.php">Buscar</a>
                            </li>
                            <?php
                                if (admin()) {
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link" onmouseover="this.classList.add('nav-hover-bg')" onmouseout="this.classList.remove('nav-hover-bg')" href="requisicoes.php">Requisições</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" onmouseover="this.classList.add('nav-hover-bg')" onmouseout="this.classList.remove('nav-hover-bg')" href="backups.php">Backups</a>
                                </li>
                            <?php
                                }
                            ?>
                        </ul>
                    <?php
                        }
                    ?>
                    <hr style="background-color: white">
                    <?php
                        if (!usuario_esta_logado()) {
                    ?>
                        <ul class="navbar-nav links-login-signin">
                            <li class="nav-item">
                                <button class="btn white black-text botao-pequeno" id="btn-login" data-toggle="modal" data-target="#modal-login">login</button>
                            </li>
                            <li class="nav-item">
                                <a href="cadastro.php" id="btn-cadastrar" class="btn btn-indigo botao-pequeno">cadastrar</a>
                            </li>
                        </ul>
                    <?php
                        } else {
                    ?>
                        <ul class="navbar-nav links-logout">
                            <li class="nav-item">
                                <a href="scripts/logout.php" id="btn-logout" class="nav-link btn btn-unique botao-pequeno" style="font-weight: bold; padding-left: 15px; padding-right: 15px;">logout</a>
                            </li>
                        </ul>
                    <?php
                        }
                    ?>
                </div>
            </div>

        </nav>

        <div class="conteudo-principal">
            <div class="container">