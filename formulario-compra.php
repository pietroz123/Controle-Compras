<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-categorias.php';
?>

<?php
    verifica_usuario();

    // Recupera todos os IDs dos compradores em todos os grupos do usuário
    $ids_compradores = recupera_ids_compradores_grupos($dbconn, $_SESSION['login-username'], $_SESSION['login-email']);
?>

        <h1 class="titulo-site">Formulário de Adição de Compra</h1>

        <!-- Formulario compra -->
        <form action="adiciona-compra.php" method="post" enctype="multipart/form-data" id="formulario-compra" class="">        
            
            <div class="grid">

                <!-- Colunas no grid sempre somam até 12 -->
                <!-- Existem 5 tipos de tamanho: xs sm md lg xl -->
            
                <div class="row">
                    <div class="col-lg">
                        <label for="input-obs" class="font-small font-weight-bold">Observações</label>
                        <input type="text" list="observacoes" id="input-obs" name="observacoes" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Digite o nome do produto">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg">
                        <label for="select-categorias" class="font-small font-weight-bold">Categorias</label>
                        <select name="categoria" id="select-categorias" class="form-control" style="width: 100%;">
                            <option></option>
                            <?php
                                foreach ($categorias = recuperar_categorias($dbconn) as $categoria)
                                    echo '<option value="'.$categoria['ID_Categoria'].'">'.$categoria['Nome_Categoria'].'</option>';
                            ?>
                        </select>
                    </div>
                    <div class="col-lg mt-2 mt-md-0">
                        <label for="select-subcategorias" class="font-small font-weight-bold">Subcategorias</label>
                        <select name="subcategorias[]" id="select-subcategorias" class="form-control" style="width: 100%;">
                            
                        </select>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg mt-3 mt-lg-0">
                        <label for="input-data" class="font-small font-weight-bold">Data</label>
                        <input type="text" id="input-data" name="data" class="form-control" value="<?= date('d/m/Y'); ?>" required readonly>
                    </div>
                </div>
                
                <hr>

                <div class="row">
                    <div class="col-lg">
                        <label for="input-valor" class="font-small font-weight-bold">Valor</label>
                        <input id="input-valor" class="form-control" type="tel" name="valor" min="0" step="0.01" placeholder="Digite o valor da compra" required>
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
                        <label for="select-comprador" class="font-small font-weight-bold">Comprador</label>
                        <select class="form-control" name="comprador-id" id="select-comprador" required>
                            <option></option>
                            <?php
                                foreach ($ids_compradores as $ids_comprador) {
                                    $comprador = buscar_comprador($dbconn, $ids_comprador['Comprador_ID']);
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
<script src="js/formulario.js"></script>
<script src="js/formulario-validacao.js"></script>