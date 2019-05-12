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
        <link type="text/css" href="lib/mdbootstrap/css/bootstrap.css" rel="stylesheet">                                            <!-- Bootstrap -->
        <link type="text/css" href="lib/mdbootstrap/css/mdb.css" rel="stylesheet">                                                  <!-- MDBootstrap -->
        <link type="text/css" href="lib/mdbootstrap/css/datatables.css" rel="stylesheet">                                           <!-- MDBootstrap / Datatables -->
        <link type="text/css" href="lib/awesomplete/css/awesomplete.css" rel="stylesheet">                                          <!-- Awesomplete -->
        <link type="text/css" href="lib/select2/css/select2.css" rel="stylesheet">                                                  <!-- Select2 -->
        <link type="text/css" href="lib/misc/css/bounce-arrow.css" rel="stylesheet">                                                <!-- Bounce-Arrow -->
        <link type="text/css" href="lib/cropper/css/cropper.css" rel="stylesheet">                                                  <!-- Cropper -->
        <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">        <!-- Toastr -->
        <link type="text/css" href="lib/air-datepicker/css/datepicker.css" rel="stylesheet">                                        <!-- Air Datepicker -->
        <link type="text/css" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">                        <!-- JQuery UI -->
        <link type="text/css" href="lib/font-awesome-animation/css/font-awesome-animation.css" rel="stylesheet">                    <!-- Font Awesome Animation -->
        
        <link type="text/css" href="css/compras.css" rel="stylesheet">                                                              <!-- CSS Site -->
        <link type="text/css" href="css/design-responsivo.css" rel="stylesheet">                                                    <!-- Design Responsivo Site -->
        
        <!-- Viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        
        <!-- Icones -->
        <link rel="shortcut icon" href="img/shopping.png" type="image/x-icon">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

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
                            <li class="nav-item li-notificacao">
                                <a role="button" class="nav-link notificacao-icone">
                                    <span><i class="fas fa-bell fa-lg"></i></span>
                                    <span class="badge-notificacao">3</span>
                                </a>
                                <div class="notificacoes-box custom-scrollbar-darker">
                                    <div class="notif clearfix">
                                        <div class="float-left">
                                            <img src="img/group.png" class="notif-icon">
                                        </div>
                                        <div class="float-right">
                                            <span class="notif-text"><b>Alice (@AliceGs)</b> te convidou para o grupo <b>Família</b>.</span>
                                            <div class="notif-time"><?= date("H:i") ?></div>
                                            <div>
                                                <span class="float-left">Deseja aceitar?</span>
                                                <div class="float-right">
                                                    <a href="#!">
                                                        <span class="badge badge-pill badge-primary">Sim</span>
                                                    </a>
                                                    <a href="#!">
                                                        <span class="badge badge-pill badge-danger">Não</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
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

        <div class="conteudo-principal" id="main-principal">
            <div class="container" id="container-principal">