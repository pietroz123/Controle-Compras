<?php 
    include("cabecalho.php"); 
    include("database/conexao.php");
    include("funcoes.php");
?>

<?php
    verifica_usuario();
?>

<?php

    $id_compra = $_POST['id'];
    $compra = buscar_compra($conexao, $id_compra);

?>

        <h1>Formulário de Alteração de Compra</h1>
        
        <form action="altera-compra.php" method="post">

            <input type="hidden" name="id" value="<?= $compra['Id'] ?>">

            <div class="grid">

                <div class="row">
                    <div class="col-lg-4">Observacoes</div>
                    <div class="col-lg-8"><input class="form-control" type="text" name="observacoes" value="<?= $compra['Observacoes'] ?>"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Data</div>
                    <div class="col-lg-8"><input class="form-control" type="date" name="data" value="<?= $compra['Data'] ?>"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Valor</div>
                    <div class="col-lg-8"><input class="form-control" type="number" name="valor" min="0" step="0.01" value="<?= $compra['Valor'] ?>"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Desconto</div>
                    <div class="col-lg-8"><input class="form-control" type="number" name="desconto" min="0" step="0.01" value="<?= $compra['Desconto'] ?>"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Forma de Pagamento</div>
                    <div class="col-lg-8">
                        <input type="radio" name="forma-pagamento" value="cartao" <?php if ($compra['Forma_Pagamento'] == "cartao") echo "checked"; ?>> Cartão<br>
                        <input type="radio" name="forma-pagamento" value="boleto" <?php if ($compra['Forma_Pagamento'] == "boleto") echo "checked"; ?>> Boleto<br>
                        <input type="radio" name="forma-pagamento" value="dinheiro" <?php if ($compra['Forma_Pagamento'] == "dinheiro") echo "checked"; ?>> Dinheiro<br>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Comprador</div>
                    <div class="col-lg-8">
                        <select class="custom-select" name="comprador-id" id="comprador-id">
                            <option class="text-muted">Selecione uma Opção</option>
                            <?php 
                                $compradores = listar($conexao, "SELECT * FROM compradores");
                                foreach ($compradores as $comprador) :
                                    $comprador_selecionado = $compra['Comprador_ID'] == $comprador['ID'];
                                    $selecionado = $comprador_selecionado ? "selected='selected'" : "";
                            ?>
                                        <option value="<?= $comprador['ID']; ?>" <?= $selecionado; ?>><?= $comprador['Nome']; ?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                </div>

            </div>

            <hr>
                        
            <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('Deseja prosseguir com a alteração?');">Alterar</button>

        </form>


<?php include("rodape.php"); ?>