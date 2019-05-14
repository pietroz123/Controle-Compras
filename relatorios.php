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
        series.tooltipText = "{value}"

        series.tooltip.pointerOrientation = "vertical";

        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;

        //chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarX = new am4core.Scrollbar();

    }

</script>