<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    
    verifica_usuario();
?>

<!-- Cartão de Busca -->
<div class="card mt-5" id="cartao-busca">
    <div class="card-body p-2 z-depth-2">
        
        <div class="card-header elegant-color-dark py-4 white-text text-uppercase">
            <div class="card-title" id="titulo-informacoes">Buscar</div>
        </div>

        <div class="elegant-color p-2 p-sm-4 text-left" id="busca">

            <div class="container white-text">
                <div class="row">
                    <div class="col"><h4 class="white-text text-left py-2">Palavra/frase chave</h4></div>
                    <div class="col-12"><input class="form-control palavra-chave" type="text" name="texto" placeholder="Digite a palavra chave"></div>
                </div>
                <hr class="white">
                <div class="row">
                    <div class="col"><h4 class="white-text text-left py-2">Data</h4></div>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="text" name="data-range" id="data-range" class="form-control" placeholder="Selecione o intervalo de datas" readonly>
                    </div>
                </div>
                <hr class="white">
                <div class="row">
                    <div class="col"><h4 class="white-text text-left py-2">Comprador</h4></div>
                    <div class="col-12">
                        <select class="custom-select" name="comprador" id="comprador">
                            <option class="text-muted">Selecione uma Opção</option>
                            <option value="0" selected>Todos</option>
                            <?php 
                                $ids_compradores = recupera_ids_compradores_grupos($dbconn, $_SESSION['login-username'], $_SESSION['login-email']);
                                foreach ($ids_compradores as $id_comprador) :
                                    $comprador = buscar_comprador($dbconn, $id_comprador['Comprador_ID']);
                            ?>
                                    <option value="<?= $comprador['ID']; ?>"><?= $comprador['Nome']; ?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <hr class="white">
            </div>

                
            <div class="d-flex justify-content-center align-content-center">
                <button class="btn btn-default" type="submit" name="submit-buscar" value="true" id="btn-busca">realizar busca</button>
            </div>
                
            
        </div>

    </div>
</div>
<!-- Fim Cartão de Busca -->

<!-- Resultado da Busca -->
<div id="resultado-busca" style="display: none;">

    <!-- Botão para voltar -->
    <div id="voltar">
        <button id="btn-voltar-busca" class="float-effect">
            <i class="fas fa-arrow-left mr-1"></i>
            Realizar uma nova busca
        </button>
    </div>

    <!-- Para ordenação da data -->
    <label class="mt-5" id="label-data">
        Data
        <select name="ordenacao-data" id="ordenacao-data" class="custom-select custom-select-sm form-control form-control-sm">
            <option>mais recente</option>
            <option>mais antiga</option>
        </select>
    </label>

    <table class="table table-hover" id="tabela-compras">

        <thead class="thead-dark">
            <tr>
                <th class="th-sm t-observacoes">Observacoes</th>
                <th class="th-sm t-data">Data</th>
                <th class="th-sm t-id">ID</th>
                <th class="th-sm t-valor">Valor</th>
                <th class="th-sm t-desconto">Desconto</th>
                <th class="th-sm t-pagamento">Pagamento</th>
                <th class="th-sm t-nome">Comprador</th>
                <th class="th-sm t-editar">Editar</th>
            </tr>
        </thead>

        <tbody id="compras-datatable">
            <!-- Preenchido ao clicar nas compras desejadas -->
        </tbody>

    </table>

    <div class="box p-3 mb-2 bg-info text-white bold" id="box-soma"></div>
    
</div>


<!-- Modal para detalhes da Compra -->
<div class="modal" id="modal-detalhes-compra">
    <div class="modal-dialog modal-lg" id="detalhes-compra">
        <!-- Preenchido com AJAX (JS) -->
    </div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>
<script src="js/compras.js"></script>

<script>

    function mostraResultado() {

        $('#cartao-busca').hide();
        $('#resultado-busca').show();

    }

    function escondeResultado() {

        $('#cartao-busca').show();
        $('#resultado-busca').hide();

    }

    $(document).ready(function() {

        // =======================================================
        // Datepicker
        // =======================================================

        $('#data-range').datepicker({
            language: 'pt-BR',
            range: true,
            toggleSelected: false,
            multipleDatesSeparator: ' - ',
            maxDate: new Date(),
            autoClose: true,
            position: 'bottom center',
            todayButton: true,
            clearButton: true
        });


        // =======================================================
        // Realização da Busca
        // =======================================================

        $('#btn-busca').click(function() {

            let requisicao = {
                "buscar_compras": "sim",
                "palavra_chave": $('.palavra-chave').val(),
                "data_range": $('#data-range').val(),
                "id_comprador": $('#comprador').val()
            };

            // Cria a tabela correspondente
            criarDataTable(requisicao);

            // Recupera a soma das compras
            delete requisicao.buscar_compras;
            $.ajax({
                url: 'scripts/recuperar-compras.php',
                method: 'POST',
                data: {
                    recuperar_soma: "sim",
                    requisicao
                },
                success: function(retorno) {
                    $('#box-soma').text("SOMA: " + retorno);
                },
                error: function(retorno) {
                    console.log('Error');
                    console.log(retorno);
                }
            }); 

            mostraResultado();

        });


        // =======================================================
        // Voltar para as opções de busca
        // =======================================================

        $('#btn-voltar-busca').click(function() {

            escondeResultado();

        });


        
        
    });

</script>