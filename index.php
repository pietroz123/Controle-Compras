<?php 
    include 'cabecalho.php'; 
    include 'includes/funcoes-usuarios.php';
?>

<?php
    mostra_alerta("success");
    mostra_alerta("danger");
?>

    <h1>Bem Vindo ao Controle de Compras</h1>

    <p>Este projeto corresponde à uma integração entre <mark>PHP</mark> e <mark>MySQL</mark> para gerenciar um Banco de Dados cujo objetivo é armazenar minhas compras pessoais, além de seus respectivos compradores.</p>

    <p>O Sistema de Gestão de Bancos de Dados utilizado é o MySQL versão <mark>8.0.12-standard</mark>.</p>

<?php
    if (usuario_esta_logado()) {
?>
        <div class="alert alert-info">Logado como <?= usuario_logado(); ?></div>
<?php
    } else {
?>
        <div class="alert alert-warning">Efetue o login ou o cadastro à partir do Menu de Navegação.</div>
<?php
    }
?>

    <div class="redes">
        <ul class="list-inline">
            <li class="list-inline-item"><a href="https://github.com/pietroz123"><img src="img/github.png" class="medium-icon" alt="Github"></a></li>
            <li class="list-inline-item"><a href="https://www.linkedin.com/in/pietro-zuntini-b23506140/"><img src="img/linkedin.png" class="medium-icon" alt="Linkedin"></a></li>
            <li class="list-inline-item"><a href="https://gitlab.com/pietroz123"><img src="img/gitlab.png" class="medium-icon" alt="Gitlab"></a></li>
        </ul>
    </div>

<?php include 'rodape.php'; ?>