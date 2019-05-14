<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php'; 
?>

    <h1 class="titulo-site">Relatórios</h1>

    <div id="grafico-compras"></div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>

<script>

    $(document).ready(function() {

        // Recupera compras
        $.ajax({
            url: 'scripts/recuperar-dados-relatorios.php',
            method: 'POST',
            data: {
                requisicao: "datas-compras"
            },
            datatype: 'json',
            success: function(retorno) {
                var json = JSON.parse(retorno);

                // Cria o gráfico de compras
                criar_grafico_compras(json.compras);
            },
            error: function(retorno) {
                console.log('Error');
                console.log(retorno);
            }
        });


    });

    function criar_grafico_compras(dados) {

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

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;

        //chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarX = new am4core.Scrollbar();

    }

    function criar_grafico_compras_v2(dados) {

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

</script>