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
            <th class="th-sm t-id">ID</th>
            <th class="th-sm t-data">Data</th>
            <th class="th-sm t-observacoes">Observacoes</th>
            <th class="th-sm t-valor">Valor</th>
            <th class="th-sm t-desconto">Desconto</th>
            <th class="th-sm t-pagamento">Pagamento</th>
            <th class="th-sm t-comprador">Comprador</th>
            <th class="th-sm t-alterar">Alterar</th>
            <th class="th-sm t-remover">Remover</th>
            <th class="th-sm t-detalhes">Detalhes</th> 
        </tr>
    </thead>

    <tbody>
    <?php
        $compras = listar($conexao, "SELECT cmp.*, cmpd.Nome AS Nome_Comprador FROM compras AS cmp JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID ORDER BY year(data), month(data), day(data);");
        foreach ($compras as $compra) :
    ?>

        <tr>
            <td class="t-id"><?= $compra['Id']; ?></td>
            <td class="t-data"><?= $compra['Data']; ?></td>
            <td class="t-observacoes"><?= $compra['Observacoes']; ?></td>
            <td class="t-valor"><?= $compra['Valor']; ?></td>
            <td class="t-desconto"><?= $compra['Desconto']; ?></td>          
            <td class="t-pagamento"><?= $compra['Forma_Pagamento']; ?></td>
            <td class="t-comprador"><?= $compra['Nome_Comprador']; ?></td>
            <td class="t-alterar">
                <form action="formulario-alterar-compra.php" method="post">
                    <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
                    <button class="btn btn-primary" style="padding: 6px 12px; margin: unset;">alterar</button>
                </form>
            </td>
            <td class="t-remover">
                <form action="remover-compra.php" method="post">
                    <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
                    <button class="btn btn-danger" onclick="return confirm('Deseja prosseguir com a remoção?');" style="padding: 6px 12px; margin: unset;">remover</button>
                </form>
            </td>
            <td class="t-detalhes">
                <button class="btn btn-info" style="padding: 6px 12px; margin: unset;" data-toggle="modal" data-target="#modal-detalhes-compra" data-id="<?= $compra['Id']; ?>" data-data="<?= $compra['Data']; ?>" data-observacoes="<?= $compra['Observacoes']; ?>" data-valor="<?= $compra['Valor']; ?>" data-desconto="<?= $compra['Desconto']; ?>" data-pagamento="<?= $compra['Forma_Pagamento']; ?>" data-comprador="<?= $compra['Nome_Comprador']; ?>">detalhes</button>
            </td>
        </tr>

    <?php
        endforeach
    ?>

    </tbody>

    <tfoot>
        <tr>
            <th class="t-id">ID</th>
            <th class="t-data">Data</th>
            <th class="t-observacoes">Observacoes</th>
            <th class="t-valor">Valor</th>
            <th class="t-desconto">Desconto</th>
            <th class="t-pagamento">Pagamento</th>
            <th class="t-comprador">Comprador</th>
            <th class="t-alterar">Alterar</th>
            <th class="t-remover">Remover</th>
            <th class="t-detalhes">Detalhes</th>            
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

    // Inicializa a tabela
    $(document).ready(function () {
        $('#tabela-compras').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ itens por página",
                "zeroRecords": "Nenhum item encontrado - desculpa",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum item encontrado",
                "infoFiltered": "(filtrado a partir de _MAX_ itens)",
                "search": "Buscar:",
                "emptyTable":     "Nenhum dado disponível na tabela",
                "loadingRecords": "Carregando...",
                "processing":     "Processando...",
                "paginate": {
                    "first":      "Primeiro",
                    "last":       "Último",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                }
            }
        });
        $('.dataTables_length').addClass('bs-select');
    });

    // Coloca as informacoes no modal
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