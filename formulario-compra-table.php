<?php 
    include("cabecalho.php"); 
    include("conexao.php");
    include("funcoes.php");
?>

        <h1>Formulário de Adição de Compra</h1>
        
        <form action="adiciona-compra.php" method="post">

            <table class="table">
            
                <tr>
                    <td>Observações</td>
                    <td><input class="form-control" type="text" name="observacoes"></td>
                </tr>

                <tr>
                    <td>Data</td>
                    <td><input class="form-control" type="date" name="data"></td>                
                </tr>

                <tr>
                    <td>Valor</td>
                    <td><input class="form-control" type="number" name="valor" min="0" step="0.01"></td>                
                </tr>

                <tr>
                    <td>Desconto</td>
                    <td><input class="form-control" type="number" name="desconto" min="0" step="0.01" value="0"></td>                
                </tr>

                <tr>
                    <td>Forma de Pagamento</td>
                    <td>
                        <input type="radio" name="forma-pagamento" value="cartao" checked> Cartão<br>
                        <input type="radio" name="forma-pagamento" value="boleto"> Boleto<br>
                        <input type="radio" name="forma-pagamento" value="dinheiro"> Dinheiro<br>
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
                            ?>
                                    <option value="<?= $comprador['ID']; ?>"><?= $comprador['Nome']; ?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </td>
                </tr>

            </table>
                        
            <button type="submit" class="btn btn-primary btn-block">Adicionar</button>

        </form>


<?php include("rodape.php"); ?>