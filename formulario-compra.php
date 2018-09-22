<?php include("cabecalho.php"); ?>

        <h1>Formulário de Adição de Compra</h1>
        
        <form action="adiciona-compra.php">

            <table class="table">
            
                <tr>
                    <td>Valor</td>
                    <td><input class="form-control" type="number" name="valor" min="0" step="0.01"></td>                
                </tr>

                <tr>
                    <td>Data</td>
                    <td><input class="form-control" type="date" name="data"></td>                
                </tr>

                <tr>
                    <td>Recebido</td>
                    <td>
                        <input type="radio" name="recebido" value="1" checked> Sim<br>
                        <input type="radio" name="recebido" value="0"> Não<br>
                    </td>                
                </tr>

                <tr>
                    <td>Observacoes</td>
                    <td><input class="form-control" type="text" name="observacoes"></td>                
                </tr>

                <tr>
                    <td>Desconto</td>
                    <td><input class="form-control" type="number" name="desconto" min="0" step="0.01"></td>                
                </tr>

                <tr>
                    <td>Forma de Pagamento ('cartao', 'boleto', 'dinheiro')</td>
                    <td>
                        <input type="radio" name="forma-pagamento" value="cartao" checked> Cartão<br>
                        <input type="radio" name="forma-pagamento" value="boleto"> Boleto<br>
                        <input type="radio" name="forma-pagamento" value="dinheiro"> Dinheiro<br>
                    </td>
                </tr>

                <tr>
                    <td>Comprador_ID</td>
                    <td><input class="form-control" type="number" name="comprador-id"></td>
                </tr>

            </table>
                        
            <button type="submit" class="btn btn-primary btn-block">Adicionar</button>

            <div class="caixa-adicao">
            </div>

        </form>


<?php include("rodape.php"); ?>