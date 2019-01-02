<?php 
    include("cabecalho.php");
    include("conexao.php"); 
    include("funcoes.php");
?>

<h1>Lista de Compras</h1>

<table class="table table-hover" id="tabela-produtos" style="width: 110%; margin-left: -35px;">

    <thead class="thead-dark">
        <tr>
            <th class="th-sm">ID</th>
            <th class="th-sm">Data</th>
            <th class="th-sm">Valor</th>
            <th class="th-sm">Observacoes</th>
            <th class="th-sm">Desconto</th>
            <th class="th-sm">Pagamento</th>
            <th class="th-sm">Comprador</th>
            <th class="th-sm"></th>
            <th class="th-sm"></th>            
        </tr>
    </thead>

    <?php
        $compras = listar($conexao, "SELECT cmp.*, cmpd.Nome AS Nome_Comprador FROM compras AS cmp JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID ORDER BY year(data), month(data), day(data);");
        foreach ($compras as $compra) :
    ?>

    <tbody>
        <tr>
            <td><?= $compra['Id']; ?></td>
            <td><?= $compra['Data']; ?></td>
            <td><?= $compra['Valor']; ?></td>
            <td><?= $compra['Observacoes']; ?></td>
            <td><?= $compra['Desconto']; ?></td>          
            <td><?= $compra['Forma_Pagamento']; ?></td>
            <td><?= $compra['Nome_Comprador']; ?></td>
            <td>
                <form action="formulario-alterar-compra.php" method="post">
                    <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
                    <button class="btn btn-primary" style="padding: 6px 12px; margin: unset;">alterar</button>
                </form>
            </td>
            <td>
                <form action="remover-compra.php" method="post">
                    <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
                    <button class="btn btn-danger" onclick="return confirm('Deseja prosseguir com a remoção?');" style="padding: 6px 12px; margin: unset;">remover</button>
                </form>
            </td>
        </tr>
    </tbody>

    <?php
        endforeach
    ?>

    <tfoot>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Valor</th>
            <th>Observacoes</th>
            <th>Desconto</th>
            <th>Pagamento</th>
            <th>Comprador</th>
            <th></th>
            <th></th>            
        </tr>
    </tfoot>

</table>

<!-- 
Obs: O comando a seguir lista todas as características de cada compra no formato de um array
    echo "<pre>";
    echo print_r($produto); 
    echo "</pre>"; 
-->

<?php include("rodape.php"); ?>

<script>
    // $(document).ready(function () {
    //     $('#tabela-produtos').DataTable();
    //     $('.dataTables_length').addClass('bs-select');
    // });
</script>