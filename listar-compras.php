<?php 
    include("cabecalho.php");
    include("conexao.php"); 
    include("funcoes.php");
?>

<h1>Lista de Compras</h1>

<!-- Tabela com as compras -->
<table class="table table-hover" id="tabela-produtos" style="width: 110%; margin-left: -35px;">

    <thead class="thead-dark">
        <tr>
            <th class="th-sm">ID</th>
            <th class="th-sm">Data</th>
            <th class="th-sm">Observacoes</th>
            <th class="th-sm">Valor</th>
            <th class="th-sm">Desconto</th>
            <th class="th-sm">Pagamento</th>
            <th class="th-sm">Comprador</th>
            <th class="th-sm">Alterar</th>
            <th class="th-sm">Remover</th>
            <th class="th-sm">Detalhes</th> 
        </tr>
    </thead>

    <tbody>
    <?php
        $compras = listar($conexao, "SELECT cmp.*, cmpd.Nome AS Nome_Comprador FROM compras AS cmp JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID ORDER BY year(data), month(data), day(data);");
        foreach ($compras as $compra) :
    ?>

        <tr>
            <td><?= $compra['Id']; ?></td>
            <td><?= $compra['Data']; ?></td>
            <td><?= $compra['Observacoes']; ?></td>
            <td><?= $compra['Valor']; ?></td>
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
            <td>
                <button class="btn btn-info" style="padding: 6px 12px; margin: unset;" data-toggle="modal" data-target="#modal-detalhes-compra" data-id="<?= $compra['Id']; ?>">detalhes</button>
            </td>
        </tr>

    <?php
        endforeach
    ?>

    </tbody>

    <tfoot>
        <tr>
            <th>ID</th>
            <th>Data</th>
            <th>Observacoes</th>
            <th>Valor</th>
            <th>Desconto</th>
            <th>Pagamento</th>
            <th>Comprador</th>
            <th>Alterar</th>
            <th>Remover</th>
            <th>Detalhes</th>            
        </tr>
    </tfoot>

</table>

<!-- Modal para detalhes da Compra -->
<div class="modal" id="modal-detalhes-compra">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Informações</h2>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                Aqui ficam as informações sobre a compra.
                <p id="id-compra"></p>
                <!-- <input type="text" id="id-compra"> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">alterar</button>
                <button type="button" class="btn btn-danger">remover</button>
            </div>
        </div>
    </div>
</div>


<?php include("rodape.php"); ?>

<script>
    $(document).ready(function () {
        $('#tabela-produtos').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });

    $('#modal-detalhes-compra').on('show.bs.modal', function(event) {
        var botao = $(event.relatedTarget);
        var id = botao.data('id');

        var modal = $(this);
        modal.find('#id-compra').val(id);
    })
</script>