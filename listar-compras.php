<?php 
    include("cabecalho.php");
    include("conexao.php"); 
    include("funcoes.php");
?>

<table class="table table-striped table-hover">

    <style>
        .table {
            width: 110%;
            margin-left: -35px;
        }
    </style>

    <thead>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Valor</th>
            <th>Observacoes</th>
            <th>Desconto</th>
            <th>Pagamento</th>
            <th>Comprador</th>
        </tr>
    </thead>

    <?php
        $compras = listar($conexao, "SELECT cmp.*, cmpd.Nome AS Nome_Comprador FROM compras AS cmp JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID ORDER BY year(data), month(data), day(data);");
        foreach ($compras as $compra) :
    ?>

    <tr>
        <td><?= $compra['Id']; ?></td>
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

</table>

<!-- 
Obs: O comando a seguir lista todas as características de cada compra no formato de um array
    echo "<pre>";
    echo print_r($produto); 
    echo "</pre>"; 
-->

<?php include("rodape.php"); ?>