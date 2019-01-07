<?php 
    include("cabecalho.php"); 
    include("funcoes-usuarios.php");
    include("logica-usuarios.php");
?>

<?php
    // mostra_alerta("success");
    // mostra_alerta("danger");
?>

<?php
    if (isset($_SESSION['success'])) {
?>
        <div class="alert alert-success" role="alert">
            <p><?php $_SESSION['success'] ?></p>    
        </div>
<?php
    unset($_SESSION['success']);
    }

    elseif (isset($_SESSION['danger'])) {
?>
        <div class="alert alert-danger" role="alert">
            <p><?php $_SESSION['danger'] ?></p>    
        </div>
<?php
    unset($_SESSION['danger']);
    }
    else {
        echo "<p>Nao tem nada nessa coisa.</p>";
    }
?>

    <h1>Bem Vindo ao Controle de Compras</h1>

    <p>Este projeto corresponde à uma integração entre <mark>PHP</mark> e <mark>MySQL</mark> para gerenciar um Banco de Dados cujo objetivo é armazenar minhas compras pessoais, além de seus respectivos compradores.</p>

    <p>O Sistema de Gestão de Bancos de Dados utilizado é o MySQL versão <mark>8.0.12-standard</mark>.</p>

<?php
    if (usuario_esta_logado()) {
?>
        <div class="alert alert-info">Logado como <?php usuario_logado(); ?></div>
<?php
    } else {
?>

        <p>Efetue o login ou o cadastro a partir do Menu de Navegacao.</p>

<?php
    }
?>

    <div class="redes">
        <ul class="list-inline">
            <li class="list-inline-item"><a href="https://github.com/pietroz123"><img src="img/github.svg" alt="Github" style="width:50px;height:50px"></a></li>
            <li class="list-inline-item"><a href="https://www.linkedin.com/in/pietro-zuntini-b23506140/"><img src="img/linkedin.png" alt="Linkedin" style="width:70px;height:70px"></a></li>
            <li class="list-inline-item"><a href="https://gitlab.com/pietroz123"><img src="img/gitlab.png" alt="Gitlab" style="width:60px;height:60px"></a></li>
        </ul>
    </div>

<?php include("rodape.php"); ?>