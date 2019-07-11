<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    
    verifica_usuario();
?>

<!-- <form action="busca-resultado.php"> -->
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
<!-- </form> -->

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

    <!-- Para ordenação da data -->
    <label class="mt-5">
        Data
        <select name="ordenacao-data" id="ordenacao-data" class="custom-select custom-select-sm form-control form-control-sm">
            <option>mais recente</option>
            <option>mais antiga</option>
        </select>
    </label>

    <tbody id="compras-datatable">
        <!-- Preenchido ao clicar nas compras desejadas -->
    </tbody>

</table>

<div class="box p-3 mb-2 bg-info text-white bold" id="soma"></div>


<!-- Modal para detalhes da Compra -->
<div class="modal" id="modal-detalhes-compra">
    <div class="modal-dialog modal-lg" id="detalhes-compra">
        <!-- Preenchido com AJAX (JS) -->
    </div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>
<script src="js/compras.js"></script>

<script>

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



        $('#btn-busca').click(function() {
            
            // Limpa e destrói a tabela
            $("#tabela-compras").DataTable().clear().destroy();

            // Constrói a tabela
            var tabela = $('#tabela-compras').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": 'scripts/recuperar-compras.php',
                    "type": 'POST',
                    "data": {
                        buscar_compras: "sim",
                        palavra_chave: $('.palavra-chave').val(),
                        data_range: $('#data-range').val(),
                        id_comprador: $('#comprador').val()
                    }
                },
                "drawCallback": function ( settings ) { // Cria os agrupamentos por Data
                    
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;            

                    api.column(1, {page:'current'} ).data().each(function ( group, i ) {

                        if ( last !== group ) {
                            $(rows).eq( i ).before(
                                '<tr class="date-group"><td colspan="6" style="background-color: #dadada">'+group+'</td></tr>'
                            );
        
                            last = group;
                        }
                    });
                },
                createdRow: function (row, data, index) {

                    let forma_pagamento = data[5];
                    var span = document.createElement('span');
                    span.className = "badge no-shadow badge-pill badge-light forma_pagamento";
                    
                    switch (forma_pagamento) {
                        case 'cartao':
                            span.textContent = "cartão";
                            break;
                        case 'boleto':
                            span.textContent = "boleto";
                            break;
                        case 'dinheiro':
                            span.textContent = "dinheiro";
                            break;
                    
                        default:
                            break;
                    }

                    $(row).children("td:nth-child(6)").html(span);
                    $(row).addClass('tr-compra');

                },
                "columns": [
                    { "name": "observacoes", "className": "t-observacoes", "width": "50%" },
                    { "name": "data", "className": "t-data" },
                    { "name": "id", "className": "t-id" },
                    { "name": "valor", "className": "t-valor" },
                    { "name": "desconto", "className": "t-desconto" },
                    { "name": "forma_pagamento", "className": "t-forma" },
                    { "name": "nome_comprador", "className": "t-nome" },
                    { "name": "editar", "className": "t-editar" }
                ],
                "footerCallback": function ( row, data, start, end, display ) { // Para recuperar a soma total das compras

                    var api = this.api(), data;
        
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
        
                    // Total over all pages
                    total = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    console.log(total);
                    $('#soma').text("SOMA = " + total);
                    
                },
                "order": [[ 1, "desc" ]]    // Ordena por Data
            });

            // Scroll até a tabela de compras
            $('html, body').animate({
                scrollTop: $('#tabela-compras').offset().top - 120
            }, 1000);

        });


        
        
    });

</script>