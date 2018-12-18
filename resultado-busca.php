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
    $id_comprador = $_GET['comprador'];
    $soma = 0;

?>

<table class="table table-striped table-hover">

<thead>
    <tr>
        <th>Data</th>
        <th>Valor</th>
        <th>Observacoes</th>
        <th>Desconto</th>
        <th>Pagamento</th>
        <th>Comprador</th>
    </tr>
</thead>

<?php

    if ($id_comprador == 0) {
        $compras = listar($conexao, "SELECT cmp.*, cmpd.Nome AS Nome_Comprador FROM compras AS cmp JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID WHERE observacoes LIKE '%{$palavraChave}%' AND data >= '{$dataInicio}' AND data <= '{$dataFim}' ORDER BY year(data), month(data), day(data);");    
    }
    else {
        $compras = listar($conexao, "SELECT cmp.*, cmpd.Nome AS Nome_Comprador FROM compras AS cmp JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID WHERE observacoes LIKE '%{$palavraChave}%' AND data >= '{$dataInicio}' AND data <= '{$dataFim}' AND Comprador_ID = {$id_comprador} ORDER BY year(data), month(data), day(data);");
    }

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
    <td><?= $compra['Nome_Comprador']; ?></td>
    <td>
        <a class="btn btn-primary" href="formulario-alterar-compra.php?id=<?= $compra['Id']; ?>">alterar</a>
    </td>
    <td>
        <form action="remover-compra.php" method="post">
            <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
            <button class="btn btn-danger" onclick="return confirm('Deseja prosseguir com a remoção?');">remover</button>
        </form>
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