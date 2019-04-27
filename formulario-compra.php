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

        <h1 class="titulo-site">Formulário de Adição de Compra</h1>

        <!-- Formulario compra -->
        <form action="adiciona-compra.php" method="post" enctype="multipart/form-data" id="formulario-compra" class="grey lighten-3 p-4 p-sm-5">        
            
            <div class="grid">

                <!-- Colunas no grid sempre somam até 12 -->
                <!-- Existem 5 tipos de tamanho: xs sm md lg xl -->
            
                <div class="row">
                    <div class="col-lg">
                        <label for="input-observacoes" class="font-small font-weight-bold">Observações</label>
                        <select class="form-control" id="select2-observacoes" name="observacoes-select" style="width: 100%;" required></select>
                        <input class="form-control" id="input-observacoes" type="hidden" name="observacoes">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg mt-3 mt-lg-0">
                        <label for="input-data" class="font-small font-weight-bold">Data</label>
                        <input id="input-data" class="form-control" type="date" name="data" required>
                    </div>
                </div>
                
                <hr>

                <div class="row">
                    <div class="col-lg">
                        <label for="input-valor" class="font-small font-weight-bold">Valor</label>
                        <input id="input-valor" class="form-control" type="tel" name="valor" min="0" step="0.01" required>
                    </div>
                    <div class="col-lg">
                        <label for="input-desconto" class="font-small font-weight-bold">Desconto</label>
                        <input id="input-desconto" class="form-control" type="number" name="desconto" min="0" step="0.01" value="0" required>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg mb-3 mb-lg-0">
                        <div class="font-small font-weight-bold mb-2">Forma de Pagamento</div>
                        <div class="d-flex justify-content-between flex-column">
                            <div class="opcao-pagamento custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="forma-pagamento" id="cartao" value="cartao" checked>
                                <label class="custom-control-label" for="cartao">Cartão</label>
                            </div>
                            <div class="opcao-pagamento custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="forma-pagamento" id="boleto" value="boleto">
                                <label class="custom-control-label" for="boleto">Boleto</label>
                            </div>                            
                            <div class="opcao-pagamento custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="forma-pagamento" id="dinheiro" value="dinheiro">
                                <label class="custom-control-label" for="dinheiro">Dinheiro</label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg">
                        <div class="list-inline">
                            <div class="list-inline-item"><button type="button" class="btn btn-light" data-toggle="modal" data-target="#modal-upload-imagem">faça o upload da nota fiscal</button></div>
                            <div class="list-inline-item">
                                <div class="status-upload mb-0 font-small text-danger">
                                    <i class="fas fa-times-circle"></i> Nenhuma imagem selecionada
                                </div>
                            </div>
                        </div>
                    
                        <div class="modal fade" id="modal-upload-imagem">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Faça upload da Nota Fiscal</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <input class="form-control-file" type="file" id="input-imagem" name="imagem" data-multiple-caption="{numero} arquivos selecionados" multiple>
                                        <label for="input-imagem">
                                            <i class="far fa-file-image"></i>
                                            <span>Selecione uma imagem</span>
                                        </label>
                                        <div id="canvas">

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="imagem-cortada" value="">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg">
                        <label for="comprador-id" class="font-small font-weight-bold">Comprador</label>
                        <select class="form-control" name="comprador-id" id="comprador-id" required>
                            <option class="text-muted" value="">Selecione uma Opção</option>
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

            </div>
            <!-- Formulario compra -->
            
            <div><button type="submit" name="submit-form-compra" id="btn-adicionar" class="btn btn-primary btn-block align-content-center">Adicionar</button></div>

        </form>

<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>

<script>

    $(document).ready(function() {

        // =======================================================
        // Mascaras
        // =======================================================

        $('#input-valor').mask('000000000000000.00', {reverse: true});


        // =======================================================
        // Realiza a busca por observações já existentes
        // =======================================================

        $('#select2-observacoes').select2({
            placeholder: 'Digite o nome do produto',
            minimumInputLength: 4,
            ajax: {
                url: "scripts/busca-observacao.php",
                type: "post",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        busca: "sim",
                        texto: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            allowClear: true,
            // Permite observações novas
            tags: true,
            createTag: function (params) {
                return {
                id: params.term,
                text: params.term,
                newOption: true
                }
            },
            templateResult: function (data) {
                var $result = $("<span></span>");

                $result.text(data.text);

                if (data.newOption) {
                $result.append(" <em>(novo)</em>");
                }

                return $result;
            }
        });

        $('#select2-observacoes').change(function() {
            // var selecionado = $('#select2-observacoes').select2('data')[0].text;
            var selecionado = $('.select2-selection__rendered').attr('title');
            $('#input-observacoes').val(selecionado);            
        });

    });


    // =======================================================
    // Para uso do Cropper.js
    // =======================================================

    var cropper;

    $('#input-imagem').on( 'change', function(e){

        if (this.files && this.files[0]) {
            var arquivos = this.files;
            var arquivo = arquivos[0];
            if ( arquivo.type.match(/^image\//) ) {

                // Cria o elemento da imagem
                $('#canvas').html('<img id="imagem-nota" alt="Imagem nota">');

                var imagem = document.getElementById("imagem-nota");
                $('#imagem-nota').attr("src", window.URL.createObjectURL(arquivo));

                // Cria o Cropper
                cropper = new Cropper(imagem, {
                    aspectRatio: NaN,
                    zoomable: false
                });

                // Adiciona o botao para cortar
                $('#modal-upload-imagem .modal-footer').html('<input type="button" class="btn btn-light btn-cortar" value="Cortar">');


                // Adiciona o nome do arquivo ao label do input
                var label	 = $('#input-imagem').siblings('label');
                var labelVal = label.val();

                var fileName = '';
                if( this.files && this.files.length > 1 )
                    fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{numero}', this.files.length );
                else
                    fileName = e.target.value.split( '\\' ).pop();

                if( fileName )
                    label.children('span').text(fileName);
                else
                    label.innerHTML = labelVal;


                // Coloca a imagem cortada no canvas
                $('.btn-cortar').click(function() {
                    
                    // Recupera a imagem em base64
                    var croppedImageDataURL = cropper.getCroppedCanvas().toDataURL("image/jpeg", 0.2);
                    $('input[type="hidden"][name="imagem-cortada"]').val(croppedImageDataURL);
                    
                    // Adiciona a imagem cortada ao canvas
                    $('#canvas').html('<img src="'+croppedImageDataURL+'" alt="Imagem cortada">');
                    arquivo = croppedImageDataURL;

                    // Muda para imagem selecionada
                    $('.status-upload').removeClass('text-danger');
                    $('.status-upload').addClass('text-success');
                    $('.status-upload').html('<i class="fas fa-check-circle"></i> Imagem selecionada');
                });

            }
            else {
                alert("Invalid file type! Please select an image file.");
            }
        }
        else {
            alert('No file(s) selected.');
        }
    });
    


</script>