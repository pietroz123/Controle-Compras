<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
?>

<?php
 
$dataPoints = array();
$y = 40;
for($i = 0; $i < 1000; $i++){
	$y += rand(0, 10) - 5; 
	array_push($dataPoints, array("x" => $i, "y" => $y));
}
 
?>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	animationEnabled: true,
	zoomEnabled: true,
	title: {
		text: "Try Zooming and Panning"
	},
	data: [{
		type: "area",     
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<?php
    include $_SERVER['DOCUMENT_ROOT'].'/rodape.php';
?>