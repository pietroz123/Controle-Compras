<?php include("cabecalho.php"); ?>
<?php include("conexao.php"); ?>

<?php 

    $resultado = mysqli_query($conexao, "select * from compras");
    while ($produto = mysqli_fetch_assoc($resultado)) {
        echo $produto['Observacoes'] . "</br>";
        // echo "<pre>";
        // echo print_r($produto); 
        // echo "</pre>";
    }

?>


<?php include("rodape.php"); ?>