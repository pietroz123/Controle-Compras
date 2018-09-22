<?php 
    include("cabecalho.php");
    include("conexao.php"); 
?>

<?php 

    function listaCompras($conexao) {
        $compras = array();
        $resultado = mysqli_query($conexao, "select * from compras");
        while ($compra = mysqli_fetch_assoc($resultado)) {
            array_push($compras, $compra);
        }
        return $compras;
    }

?>

<table class="table table-striped table-hover table-fixed">

    <thead>
        <tr>
            <th scope="col">Data</th>
            <th scope="col">Valor</th>
            <th scope="col">Observacoes</th>
            <th scope="col">Desconto</th>
            <th scope="col">Forma de Pagamento</th>
            <th scope="col">Comprador ID</th>
        </tr>
    </thead>

    <?php
        $compras = listaCompras($conexao);
        foreach ($compras as $compra) :
    ?>

    <tr>
        <td><?= $compra['Data']; ?></td>
        <td><?= $compra['Valor']; ?></td>
        <td><?= $compra['Observacoes']; ?></td>
        <td><?= $compra['Desconto']; ?></td>            
        <td><?= $compra['Forma_Pagamento']; ?></td>
        <td><?= $compra['Comprador_ID']; ?></td>
    </tr>

    <?php
        endforeach
    ?>

</table>

<!-- 
Obs: O comando a seguir lista todas as características de cada compra no formato de um array
    echo "<pre>";
    echo print_r($produto); 
    echo "</pre>"; 
-->

<?php include("rodape.php"); ?>