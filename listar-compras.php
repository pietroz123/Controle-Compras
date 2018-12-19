<?php 
    include("cabecalho.php");
    include("conexao.php"); 
    include("funcoes.php");
?>

<table class="table table-hover">

    <style>
        .table {
            width: 110%;
            margin-left: -35px;
        }
    </style>

    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Data</th>
            <th scope="col">Valor</th>
            <th scope="col">Observacoes</th>
            <th scope="col">Desconto</th>
            <th scope="col">Pagamento</th>
            <th scope="col">Comprador</th>
            <th scope="col"></th>
            <th scope="col"></th>            
        </tr>
    </thead>

    <?php
        $compras = listar($conexao, "SELECT cmp.*, cmpd.Nome AS Nome_Comprador FROM compras AS cmp JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID ORDER BY year(data), month(data), day(data);");
        foreach ($compras as $compra) :
    ?>

    <tbody>
        <tr>
            <th scope="row"><?= $compra['Id']; ?></th>
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
    </tbody>

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