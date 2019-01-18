<?php 
    include 'cabecalho.php';
    include 'database/conexao.php'; 
    include 'funcoes.php';
?>

<?php
    verifica_usuario();
?>

<!-- Recebe os dados da pesquisa -->
<?php

    $palavraChave = $_GET['texto'];
    $dataInicio = $_GET['dataInicio'];
    $dataFim = $_GET['dataFim'];
    $id_comprador = $_GET['comprador'];
    $soma = 0;

?>

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
                    <button class="btn btn-primary botao-pequeno">alterar</button>
                </form>
            </td>
            <td class="t-remover">
                <form action="remover-compra.php" method="post">
                    <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
                    <button class="btn btn-danger botao-pequeno" onclick="return confirm('Deseja prosseguir com a remoção?');">remover</button>
                </form>
            </td>
            <td class="t-detalhes">
                <button type="button" id="<?= $compra['Id']; ?>" class="btn btn-info botao-pequeno btn-detalhes">detalhes</button>
            </td>
        </tr>

    <?php
        endforeach
    ?>
    </tbody>

</table><br>

<div class="box p-3 mb-2 bg-info text-white">
    SOMA = <?= $soma; ?>
</div>


<!-- Modal para detalhes da Compra -->
<div class="modal" id="modal-detalhes-compra">
    <div class="modal-dialog" id="detalhes-compra">
        <!-- Preenchido com AJAX (JS) -->
    </div>
</div>



<?php include 'rodape.php'; ?>

<script>

    //* <button class="btn btn-info botao-pequeno" data-toggle="modal" data-target="#modal-detalhes-compra" data-id="<?= $compra['Id']; ?>" data-data="<?= $compra['Data']; ?>" data-observacoes="<?= $compra['Observacoes']; ?>" data-valor="<?= $compra['Valor']; ?>" data-desconto="<?= $compra['Desconto']; ?>" data-pagamento="<?= $compra['Forma_Pagamento']; ?>" data-comprador="<?= $compra['Nome_Comprador']; ?>">detalhes</button>
    // // Coloca as informacoes no modal
    // $('#modal-detalhes-compra').on('show.bs.modal', function(event) {
    //     // Recupera as informacoes do botao
    //     var botao = $(event.relatedTarget);
    //     var id = botao.data('id');
    //     var data = botao.data('data');
    //     var observacoes = botao.data('observacoes');
    //     var valor = botao.data('valor');
    //     var desconto = botao.data('desconto');
    //     var pagamento = botao.data('pagamento');
    //     var comprador = botao.data('comprador');
        
    //     // Imprime nos campos do modal-detalhes-compra
    //     var modal = $(this);
    //     modal.find('#id-compra').val(id);
    //     modal.find("#data-compra").val(data);
    //     modal.find("#observacoes-compra").val(observacoes);
    //     modal.find("#valor-compra").val(valor);
    //     modal.find("#desconto-compra").val(desconto);
    //     modal.find("#pagamento-compra").val(pagamento);
    //     modal.find("#comprador-compra").val(comprador);
    // });


    // Preenche o modal-detalhes-compra utilizando AJAX
    $(".btn-detalhes").click(function() {
        var id_compra = $(this).attr("id");        

        $.ajax({
            url: "modal-detalhes-produto.php",
            method: "post",
            data: {
                id_compra: id_compra
            },
            success: function(data) {
                $("#detalhes-compra").html(data);
                $("#modal-detalhes-compra").modal("show");
            }
        });
    });
    

</script>