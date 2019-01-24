<?php
    ob_start();
    include("logica-usuarios.php");
?>
<html>

    <head>
        <title>Minhas Compras</title>
        <meta charset="utf-8">
        
        <!-- CSSs -->
        <link rel="shortcut icon" href="img/shopping.png" type="image/x-icon">
        <link type="text/css" href="css/bootstrap4.css"rel="stylesheet">
        <link type="text/css" href="css/mdb.css" rel="stylesheet">
        <link type="text/css" href="css/datatables.css" rel="stylesheet">
        <link type="text/css" href="css/compras.css" rel="stylesheet">
        
        <!-- Viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Fontes de Texto -->
        <link href="https://fonts.googleapis.com/css?family=Merriweather|Slabo+27px" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <!-- Icones -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    </head>

    <body>

        <!-- Modal de Login -->
        <?php include("modal-login.php"); ?>
        <?php include("modal-cadastro.php"); ?>

        <!-- Menu de navegação: no Bootstrap é a classe navbar -->
        <!-- https://www.youtube.com/watch?v=23bpce-5s8I -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
                
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Home</a>
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
                            <a class="nav-link" onmouseover="this.classList.add('nav-hover-bg')" onmouseout="this.classList.remove('nav-hover-bg')" href="formulario-compra-grid.php">Adicionar Compra</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onmouseover="this.classList.add('nav-hover-bg')" onmouseout="this.classList.remove('nav-hover-bg')" href="formulario-comprador-grid.php">Adicionar Comprador</a>
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
                            <button class="btn btn-primary botao-pequeno" style="margin-right: 10px;" data-toggle="modal" data-target="#modal-login">login</button>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-indigo botao-pequeno" data-toggle="modal" data-target="#modal-cadastro">cadastrar</button>                        
                        </li>
                    </ul>
                <?php
                    } else {
                ?>
                    <ul class="navbar-nav links-logout">
                        <li class="nav-item mr-2">
                            <a href="perfil-usuario.php">
                                <span class="badge badge-light">
                                    <img src="img/usuario.png" class="imagem-usuario">
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link btn btn-unique botao-pequeno">logout</a>
                        </li>
                    </ul>
                <?php
                    }
                ?>
            </div>

        </nav>

        <div class="container">
            <div class="conteudo-principal">