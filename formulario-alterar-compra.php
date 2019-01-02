<?php 
    include("cabecalho.php"); 
    include("conexao.php");
    include("funcoes.php");
?>

<?php

    $id_compra = $_POST['id'];
    $compra = buscar_compra($conexao, $id_compra);

?>

        <h1>Formulário de Alteração de Compra</h1>
        
        <form action="altera-compra.php" method="post">

            <input type="hidden" name="id" value="<?= $compra['Id'] ?>">

            <table class="table">
            
                <tr>
                    <td>Observacoes</td>
                    <td><input class="form-control" type="text" name="observacoes" value="<?= $compra['Observacoes'] ?>"></td>                
                </tr>

                <tr>
                    <td>Data</td>
                    <td><input class="form-control" type="date" name="data" value="<?= $compra['Data'] ?>"></td>                
                </tr>

                <tr>
                    <td>Valor</td>
                    <td><input class="form-control" type="number" name="valor" min="0" step="0.01" value="<?= $compra['Valor'] ?>"></td>                
                </tr>

                <tr>
                    <td>Desconto</td>
                    <td><input class="form-control" type="number" name="desconto" min="0" step="0.01" value="<?= $compra['Desconto'] ?>"></td>
                </tr>

                <tr>
                    <td>Forma de Pagamento ('cartao', 'boleto', 'dinheiro')</td>
                    <td>
                        <input type="radio" name="forma-pagamento" value="cartao" <?php if ($compra['Forma_Pagamento'] == "cartao") echo "checked"; ?>> Cartão<br>
                        <input type="radio" name="forma-pagamento" value="boleto" <?php if ($compra['Forma_Pagamento'] == "boleto") echo "checked"; ?>> Boleto<br>
                        <input type="radio" name="forma-pagamento" value="dinheiro" <?php if ($compra['Forma_Pagamento'] == "dinheiro") echo "checked"; ?>> Dinheiro<br>
                    </td>
                </tr>

                <tr>
                    <td>Comprador</td>
                    <td>
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
                    </td>
                </tr>

            </table>
                        
            <button type="submit" class="btn btn-warning btn-block" onclick="return confirm('Deseja prosseguir com a alteração?');">Alterar</button>

        </form>


<?php include("rodape.php"); ?>