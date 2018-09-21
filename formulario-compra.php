<?php include("cabecalho.php"); ?>

        <h1>Formulário de Adição de Compra</h1>
        
        <form action="adiciona-compra.php">
        
            <div class="caixa-adicao">
                <label>Valor</label>:<br>
                    <input type="number" name="valor" min="0" step="0.01"><br>
            </div>
            
            <div class="caixa-adicao">
                <label>Data</label>:<br>
                    <input type="date" name="data"><br>            
            </div>

            <div class="caixa-adicao">
                <label>Recebido</label>:<br>
                    <input type="radio" name="recebido" value="1" checked> Sim<br>
                    <input type="radio" name="recebido" value="0"> Não<br>
            </div>

            <div class="caixa-adicao">
                <label>Observacoes</label>:<br>
                    <input type="text" name="observacoes"><br>
            </div>

            <div class="caixa-adicao">
                <label>Desconto</label>:<br>
                    <input type="number" name="desconto" min="0" step="0.01"><br>
            </div>

            <div class="caixa-adicao">
                <label>Forma de Pagamento</label>: ('cartao', 'boleto', 'dinheiro')<br>
                    <input type="radio" name="forma-pagamento" value="cartao" checked> Cartão<br>
                    <input type="radio" name="forma-pagamento" value="boleto"> Boleto<br>
                    <input type="radio" name="forma-pagamento" value="dinheiro"> Dinheiro<br>
            </div>

            <div class="caixa-adicao">
                <label>Comprador_ID</label>:<br>
                    <input type="number" name="comprador-id"><br>
            </div>

            <div class="caixa-adicao">
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>

        </form>


<?php include("rodape.php"); ?>