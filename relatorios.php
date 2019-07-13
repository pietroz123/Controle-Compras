<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';

    verifica_usuario();
?>

    <!-- Header com o título e o select com os anos -->
    <div class="header-relatorios">
    
        <h1 class="titulo-site">Relatórios</h1>

        <!-- Anos disponíveis para visualização -->
        <div class="anos-disponiveis mb-4"></div>

    </div>

    <!-- Mensagem de ajuda -->
    <div class="mensagem-ajuda">
        <div class="alert alert-primary">
            <span>Selecione o ano que deseja visualizar.</span>
        </div>
    </div>

    <!-- Gráfico de compras -->
    <div id="grafico-compras"></div>

    <!-- Div onde as compras de determinado dia irão aparecer -->
    <div id="compras"></div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>
<script src="js/relatorios.js"></script>