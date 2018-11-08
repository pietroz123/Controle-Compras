<?php 
    include("cabecalho.php");
    include("conexao.php"); 
    include("funcoes.php");
?>

<!-- Recebe os dados da pesquisa -->
<?php

    $palavraChave = $_GET['texto'];
    $dataInicio = $_GET['dataInicio'];
    $dataFim = $_GET['dataFim'];
    $soma = 0;

?>

<table class="table table-striped table-hover">

<thead>
    <tr>
        <th>Data</th>
        <th>Valor</th>
        <th>Observacoes</th>
        <th>Desconto</th>
        <th>Forma de Pagamento</th>
        <th>Comprador ID</th>
    </tr>
</thead>

<?php
    $compras = listar($conexao, "select * from compras where observacoes like '%{$palavraChave}%' and data >= '{$dataInicio}' and data <= '{$dataFim}' order by year(data), month(data), day(data);");
    foreach ($compras as $compra) :
        $valor = $compra['Valor'];
        $soma += $valor;
?>

<tr>
    <td><?= $compra['Data']; ?></td>
    <td><?= $compra['Valor']; ?></td>
    <td><?= $compra['Observacoes']; ?></td>
    <td><?= $compra['Desconto']; ?></td>            
    <td><?= $compra['Forma_Pagamento']; ?></td>
    <td><?= $compra['Comprador_ID']; ?></td>
    <td>
        <a href="remover-compra.php" class="text-danger">remover</a>
    </td>
</tr>

<?php
    endforeach
?>

</table><br>

<div class="box p-3 mb-2 bg-info text-white">
    SOMA = <?= $soma; ?>
</div>


<?php include("rodape.php"); ?>