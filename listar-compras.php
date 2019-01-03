<?php 
    include("cabecalho.php");
    include("conexao.php"); 
    include("funcoes.php");
?>

<h1>Lista de Compras</h1>

<!-- Tabela com as compras -->
<table class="table table-hover" id="tabela-compras" style="width: 110%; margin-left: -50px;">

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
                <button class="btn btn-info" style="padding: 6px 12px; margin: unset;" data-toggle="modal" data-target="#modal-detalhes-compra" data-id="<?= $compra['Id']; ?>" data-data="<?= $compra['Data']; ?>" data-observacoes="<?= $compra['Observacoes']; ?>" data-valor="<?= $compra['Valor']; ?>" data-desconto="<?= $compra['Desconto']; ?>" data-pagamento="<?= $compra['Forma_Pagamento']; ?>" data-comprador="<?= $compra['Nome_Comprador']; ?>">detalhes</button>
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
                <div class="grid">
                    <div class="row">
                        <div class="col-3">ID</div>
                        <div class="col-9"><input type="text" class="form-control" id="id-compra" readonly></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Data</div>
                        <div class="col-9"><input class="form-control" type="date" name="data" id="data-compra" readonly></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Obs.</div>
                        <div class="col-9"><input class="form-control" type="text" name="observacoes" id="observacoes-compra" readonly></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Valor</div>
                        <div class="col-9"><input class="form-control" type="number" name="valor" min="0" step="0.01" id="valor-compra" readonly></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Desconto</div>
                        <div class="col-9"><input class="form-control" type="number" name="desconto" min="0" step="0.01" value="0"  id="desconto-compra" readonly></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Pagamento</div>
                        <div class="col-9"><input type="text" class="form-control" name="forma-pagamento" id="pagamento-compra" readonly></div>
                    </div>
                    <div class="row">
                        <div class="col-3">Comprador</div>
                        <div class="col-9"><input type="text" class="form-control" name="comprador" id="comprador-compra" readonly></div>
                    </div>
                </div>
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
        $('#tabela-compras').DataTable();
        $('.dataTables_length').addClass('bs-select');
    });

    $('#modal-detalhes-compra').on('show.bs.modal', function(event) {
        // Recupera as informacoes do botao
        var botao = $(event.relatedTarget);
        var id = botao.data('id');
        var data = botao.data('data');
        var observacoes = botao.data('observacoes');
        var valor = botao.data('valor');
        var desconto = botao.data('desconto');
        var pagamento = botao.data('pagamento');
        var comprador = botao.data('comprador');
        
        // Imprime nos campos do modal-detalhes-compra
        var modal = $(this);
        modal.find('#id-compra').val(id);
        modal.find("#data-compra").val(data);
        modal.find("#observacoes-compra").val(observacoes);
        modal.find("#valor-compra").val(valor);
        modal.find("#desconto-compra").val(desconto);
        modal.find("#pagamento-compra").val(pagamento);
        modal.find("#comprador-compra").val(comprador);

    });
</script>