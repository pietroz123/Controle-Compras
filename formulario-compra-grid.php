<?php 
    include("cabecalho.php"); 
    include("conexao.php");
    include("funcoes.php");
?>

<?php
    verifica_usuario();
?>

        <h1>Formulário de Adição de Compra</h1>

        <form action="adiciona-compra.php" method="post">        
            
            <div class="grid">

                <!-- Colunas no grid sempre somam até 12 -->
                <!-- Existem 5 tipos de tamanho: xs sm md lg xl -->
            
                <div class="row">
                    <div class="col-lg-4">Observações</div>
                    <div class="col-lg-8"><input class="form-control" type="text" name="observacoes"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Data</div>
                    <div class="col-lg-8"><input class="form-control" type="date" name="data"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Valor</div>
                    <div class="col-lg-8"><input class="form-control" type="number" name="valor" min="0" step="0.01"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Desconto</div>
                    <div class="col-lg-8"><input class="form-control" type="number" name="desconto" min="0" step="0.01" value="0"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Forma de Pagamento</div>
                    <div class="col-lg-8">
                        <input type="radio" name="forma-pagamento" value="cartao" checked> Cartão<br>
                        <input type="radio" name="forma-pagamento" value="boleto"> Boleto<br>
                        <input type="radio" name="forma-pagamento" value="dinheiro"> Dinheiro<br>
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
                            ?>
                                    <option value="<?= $comprador['ID']; ?>"><?= $comprador['Nome']; ?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <hr>
            </div>
            
            <div><button type="submit" class="btn btn-primary btn-block align-content-center">Adicionar</button></div>

        </form>

<?php include("rodape.php"); ?>