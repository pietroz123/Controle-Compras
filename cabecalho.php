<html>

    <head>
        <title>Minhas Compras</title>
        <meta charset="utf-8">
        
        <!-- CSSs -->
        <link type="text/css" href="css/bootstrap4.css"rel="stylesheet">
        <link type="text/css" href="css/compras.css" rel="stylesheet">
        
        <!-- Viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Fontes de Texto -->
        <link href="https://fonts.googleapis.com/css?family=Merriweather|Slabo+27px" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Scripts (Javascript) -->
        <script src="js/jquery-2.1.3.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
                        <a class="nav-link" href="formulario-comprador.php">Adicionar Comprador</a>
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