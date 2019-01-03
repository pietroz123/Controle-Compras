<html>

    <head>
        <title>Minhas Compras</title>
        <meta charset="utf-8">
        
        <!-- CSSs -->
        <link type="text/css" href="css/bootstrap4.css"rel="stylesheet">
        <link type="text/css" href="css/mdb.css" rel="stylesheet">
        <link type="text/css" href="css/datatables.css" rel="stylesheet">
        <link type="text/css" href="css/compras.css" rel="stylesheet">
        
        <!-- Viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Fontes de Texto -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather|Slabo+27px">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    </head>

    <body>

        <!-- Menu de navegação: no Bootstrap é a classe navbar -->
        <!-- https://www.youtube.com/watch?v=23bpce-5s8I -->
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
                
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Home</a>
            </div>

            <button class="navbar-toggler">
                <span class="navbar-toggler-icon" data-toggle="collapse" data-target="#navbarMenu"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="formulario-compra-grid.php">Adicionar Compra</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="formulario-comprador-grid.php">Adicionar Comprador</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar-compras.php">Compras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buscar.php">Buscar</a>
                    </li>
                </ul>
            </div>

        </nav>

        <div class="container">
            <div class="conteudo-principal">