<?php
    include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
?>

<?php
    if (isset($_POST['id_compra'])) {
        $id = $_POST['id_compra'];
        $compra = buscar_compra($dbconn, $id);
?>

<div class="modal-content">
    <div class="modal-header">
        <h2>Informações</h2>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
    </div>
    <div class="modal-body">
        <div class="grid">
            <div class="row">
                <div class="col-3">ID</div>
                <div class="col-9"><input type="text" class="form-control" id="id-compra" value="<?= $compra['Id'] ?>" readonly></div>
            </div>
            <div class="row">
                <div class="col-3">Data</div>
                <div class="col-9"><input class="form-control" type="date" name="data" id="data-compra" value="<?= $compra['Data'] ?>" readonly></div>
            </div>
            <div class="row">
                <div class="col-3">Observação</div>
                <div class="col-9"><input class="form-control" type="text" name="observacoes" id="observacoes-compra" value="<?= $compra['Observacoes'] ?>" readonly></div>
            </div>
            <div class="row">
                <div class="col-3">Valor</div>
                <div class="col-9"><input class="form-control" type="number" name="valor" min="0" step="0.01" id="valor-compra" value="<?= $compra['Valor'] ?>" readonly></div>
            </div>
            <div class="row">
                <div class="col-3">Desconto</div>
                <div class="col-9"><input class="form-control" type="number" name="desconto" min="0" step="0.01" value="0"  id="desconto-compra" value="<?= $compra['Desconto'] ?>" readonly></div>
            </div>
            <div class="row">
                <div class="col-3">Pagamento</div>
                <div class="col-9"><input type="text" class="form-control" name="forma-pagamento" id="pagamento-compra" value="<?= $compra['Forma_Pagamento'] ?>" readonly></div>
            </div>
            <?php
                // Recupera o comprador
                $comprador = buscar_comprador($dbconn, $compra['Comprador_ID']);
            ?>
            <div class="row">
                <div class="col-3">Comprador</div>
                <div class="col-9"><input type="text" class="form-control" name="comprador" id="comprador-compra" value="<?= $comprador['Nome'] ?>" readonly></div>
            </div>
            <hr>
            <div class="row">
                <div class="col"><button type="button" class="btn light-blue btn-block" id="btn-mostrar-imagem" value="<?= $compra['Imagem'] ?>">mostrar imagem</button></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <form action="formulario-alterar-compra.php" method="post">
            <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
            <button class="btn btn-primary" style="float: left;">alterar</button>
        </form>
        <form action="scripts/remover-compra.php" method="post">
            <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
            <button class="btn btn-danger" style="float: right;" name="submit-remover" onclick="return confirm('Deseja prosseguir com a remoção?');">remover</button>
        </form>
    </div>
</div>

<?php
    }
?>

<script>

    $("#btn-mostrar-imagem").click(function() {
        var nome_imagem = document.getElementById("btn-mostrar-imagem").value;
        
        if (nome_imagem) {
            $(this).html("<img src='scripts/imagem.php?imagem=<?= $compra['Imagem'] ?>' class='responsive'>");
        }
        else {
            $(this).html("<div class='text-danger'>Imagem indisponível!</div>");
        }
    });

</script>