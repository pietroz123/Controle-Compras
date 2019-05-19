<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';

    verifica_usuario();
?>

    <!-- Header com o título e o select com os anos -->
    <div class="header-relatorios">
        <h1 class="titulo-site">Relatórios</h1>
        <select name="select-ano" id="select-ano" class="form-control">
            <?php
                $sql = "SELECT DISTINCT YEAR(c.Data) as Ano
                FROM compras c
                WHERE c.Comprador_ID = (
                    SELECT co.ID
                    FROM compradores co
                    WHERE co.Email = '".$_SESSION['login-email']."'
                )";
                $resultado = mysqli_query($conexao, $sql);
                while ($ano = mysqli_fetch_assoc($resultado))
                    echo '<option value="'.$ano['Ano'].'">'.$ano['Ano'].'</option>';
            ?>
        </select>
    </div>

    <!-- Mensagem de ajuda -->
    <div class="alert alert-info">
        <span>Clique nas bolinhas para visualizar as compras daquele dia.</span>
    </div>

    <!-- Gráfico de compras -->
    <div id="grafico-compras"></div>

    <!-- Div onde as compras de determinado dia irão aparecer -->
    <div id="compras"></div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>

<script>

    function recuperaCompras(ano) {
        $.ajax({
            url: 'scripts/recuperar-dados-relatorios.php',
            method: 'POST',
            data: {
                requisicao: "datas-compras",
                ano: ano
            },
            datatype: 'json',
            success: function(retorno) {
                var json = JSON.parse(retorno);

                // Cria o gráfico de compras
                criarGraficoCompras(json.compras);
            },
            error: function(retorno) {
                console.log('Error');
                console.log(retorno);
            }
        });
    }

    // Recupera as compras iniciais
    $(document).ready(function() {

        var ano_inicial = $('#select-ano').val();

        // Recupera compras
        recuperaCompras(ano_inicial);


    }); // document ready


    // ==========================================================
    // Permite o usuário selecionar o ano que deseja visualizar
    // ==========================================================

    $('#select-ano').change(function() {
        var ano = $(this).val();
        recuperaCompras(ano);        
    });



    function criarGraficoCompras(dados) {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("grafico-compras", am4charts.XYChart);

        var data = [];
        for(let i = 0; i < dados.length; i++) {

            // Criação da data da compra
            var data_compra = dados[i].Data;
            var split = data_compra.split("-");
            var ano = parseInt(split[0]);
            var mes = parseInt(split[1]);
            var dia = parseInt(split[2]);
            var date_compra = new Date(ano, mes-1, dia);

            // Criação do valor da compra
            var valor_compra = dados[i].Valor;

            data.push({date:date_compra, value: valor_compra});
        }

        chart.data = data;

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 60;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.strokeWidth = 2;
        series.tooltipText = "{value}"

        series.tooltip.pointerOrientation = "vertical";
        
        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        // ==============================================================================================================
        // Caso o usuário clique em um valor, recupera os dados do dia (dia e valor total)
        // ==============================================================================================================

        bullet.events.on("hit", function(event) {
            var item = event.target.dataItem.dataContext;

            var data_compra = new Date(item.date);
            var dia = data_compra.getDate();        // Por incrível que pareça, retorna o dia de 1 a 31, e não a data
            var mes = data_compra.getMonth() + 1;   // Note: 0=January, 1=February etc.
            var ano = data_compra.getFullYear();

            // Zera as compras
            $('#compras').empty();

            // Mostra a data das compras
            $('#compras').append('<h1 class="text-left mt-5">Compras do dia '+dia+'/'+mes+'/'+ano+'</h1>');

            $.ajax({
                url: 'scripts/recuperar-compras.php',
                method: 'POST',
                data: {
                    data_compra: ano+'-'+mes+'-'+dia
                },
                datatype: 'html',
                success: function(retorno) {
                    // Tabela das compras
                    $('#compras').append(retorno);

                    inicializaDataTable();
                },
                error: function(retorno) {
                    console.log('Error');
                    console.log(retorno);
                }
            });

        }); // bullet hit event

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;

        // chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarX = new am4core.Scrollbar();

    }

    function criarGraficoComprasV2(dados) {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("grafico-compras", am4charts.XYChart);

        var data = [];
        for(let i = 0; i < dados.length; i++) {

            // Criação da data da compra
            var data_compra = dados[i].Data;

            // Criação do valor da compra
            var valor_compra = dados[i].Valor;

            data.push({date: data_compra, value: valor_compra});
        }

        chart.data = data;

        // Set input format for the dates
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"
        series.strokeWidth = 2;
        series.minBulletDistance = 15;

        // Drop-shaped tooltips
        series.tooltip.background.cornerRadius = 20;
        series.tooltip.background.strokeOpacity = 0;
        series.tooltip.pointerOrientation = "vertical";
        series.tooltip.label.minWidth = 40;
        series.tooltip.label.minHeight = 40;
        series.tooltip.label.textAlign = "middle";
        series.tooltip.label.textValign = "middle";

        // Make bullets grow on hover
        var bullet = series.bullets.push(new am4charts.CircleBullet());
        bullet.circle.strokeWidth = 2;
        bullet.circle.radius = 4;
        bullet.circle.fill = am4core.color("#fff");

        var bullethover = bullet.states.create("hover");
        bullethover.properties.scale = 1.3;

        // Make a panning cursor
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.behavior = "panXY";
        chart.cursor.xAxis = dateAxis;
        chart.cursor.snapToSeries = series;

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series);
        chart.scrollbarX.parent = chart.bottomAxesContainer;

    }


    // =======================================================
    // Funções Auxiliares
    // =======================================================

    // Função para reinicializar a DataTable

    function inicializaDataTable() {
        $('#tabela-compras').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ itens por página",
                "zeroRecords": "Nenhum item encontrado - desculpa",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum item encontrado",
                "infoFiltered": "(filtrado a partir de _MAX_ itens)",
                "search": "Buscar:",
                "emptyTable":     "Nenhum dado disponível na tabela",
                "loadingRecords": "Carregando...",
                "processing":     "Processando...",
                "paginate": {
                    "first":      "Primeiro",
                    "last":       "Último",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                }
            },
            "order": [[ 1, "desc" ]]    // Ordena por Data
        });
        $('.dataTables_length').addClass('bs-select');
    }

</script>