<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
?>

<?php
    verifica_usuario();

    // Recupera todos os IDs dos compradores em todos os grupos do usuário
    $ids_compradores = recupera_ids_compradores_grupos($conexao, $_SESSION['login-username'], $_SESSION['login-email']);
?>

        <h1>Formulário de Adição de Compra</h1>

        <form action="adiciona-compra.php" method="post" enctype="multipart/form-data">        
            
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
                                foreach ($ids_compradores as $ids_comprador) {
                                    $comprador = buscar_comprador($conexao, $ids_comprador['Comprador_ID']);
                            ?>
                                    <option value="<?= $comprador['ID']; ?>"><?= $comprador['Nome']; ?></option>

                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Imagem (Opcional)</div>
                    <div class="col-lg-8">
                        <input class="form-control-file" type="file" id="input-imagem" name="imagem" data-multiple-caption="{numero} arquivos selecionados" multiple>
                        <label for="input-imagem">
                            <i class="far fa-file-image"></i>
                            <span>Selecione uma imagem</span>
                        </label>
                    </div>
                </div>
                <hr>
            </div>
            
            <div><button type="submit" name="submit-form-compra" class="btn btn-primary btn-block align-content-center">Adicionar</button></div>

        </form>

<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>

<script>

    // https://tympanus.net/codrops/2015/09/15/styling-customizing-file-inputs-smart-way/
    var inputs = $('#input-imagem');
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{numero}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });
    });

    


</script>