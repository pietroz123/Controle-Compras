/// <reference path='../lib/jquery/js/jquery-latest.js' />
/// <reference path='../lib/mdbootstrap/js/datatables.js' />

// =======================================================
// Auxiliares
// =======================================================

$.extend( $.fn.dataTable.defaults, {
    responsive: true
} );

function inicializaDataTable() {
    $('#tabela-compras').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        }
    });
}

function formatarData(string) {

    let data    = string.split("-");
    let dia     = data[2];
    let mes     = data[1];
    let ano     = data[0];

    let dataFormatada = dia + "/" + mes + "/" + ano;
    return dataFormatada;

}

// =======================================================
// Inicializa a tabela de dados
// =======================================================

function criarDataTable(requisicao) {

    // Limpa e destrói a tabela
    $("#tabela-compras").DataTable().clear().destroy();

    // Constrói a tabela
    $('#tabela-compras').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": 'scripts/recuperar-compras.php',
            "type": 'POST',
            "data": {
                requisicao
            }
        },
        "drawCallback": function ( settings ) { // Cria os agrupamentos por Data
            
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;            

            api.column(1, {page:'current'} ).data().each(function ( group, i ) {

                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="date-group"><td colspan="6" style="background-color: #dadada">'+formatarData(group)+'</td></tr>'
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
        "order": [[ 1, "desc" ]]    // Ordena por Data
    });

    $('#container-compras').show();

}


// =======================================================
// FILTRO DA DATA (compras mais recentes e mais antigas)
// =======================================================

$(document).on('change', '#ordenacao-data', function() {

    let data = $(this).children("option:selected").text();
    
    if (data == "mais recente")
        $("#tabela-compras").DataTable()
            .order( [[ 1, 'desc' ]] )
            .draw();
    else 
        // mais antiga
        $("#tabela-compras").DataTable()
            .order( [[ 1, 'asc' ]] )
            .draw();
    
});


// ======================================================================================================================================
// ==================================== AO CLICAR EM UM GRUPO, RECUPERA AS COMPRAS DAQUELE GRUPO ========================================
// ======================================================================================================================================

$('.link-cartao-grupo').click(function () {

    // Recupera o ID do grupo
    var id_grupo = $(this).attr('id-grupo');

    let requisicao = {
        "id_grupo": id_grupo
    };

    // Cria a tabela correspondente
    criarDataTable(requisicao);

    // Atualiza na view
    $('#titulo-compras').text($(this).find('.cg-nome').text());

    // Scroll até a tabela de compras
    $('html, body').animate({
        scrollTop: $('#tabela-compras').offset().top - 120
    }, 1000);
    
});


// ======================================================================================================================================
// ================================== AO CLICAR EM MINHAS COMPRAS, RECUPERA AS COMPRAS DAQUELE COMPRADOR ================================
// ======================================================================================================================================

$('.link-cartao-minhas-compras').click(function () {

    let requisicao = {
        "todas": "sim"
    };

    // Cria a tabela correspondente
    criarDataTable(requisicao);

    // Atualiza na view
    $('#titulo-compras').text("Minhas Compras");

    // Scroll até a tabela de compras
    $('html, body').animate({
        scrollTop: $('#tabela-compras').offset().top - 120
    }, 1000);
    
});


// =======================================================
// Preenche o modal-detalhes-compra utilizando AJAX
// =======================================================

$(document).on('click', '#btn-editar-compra', function() {
    console.log("aqui");
    var id_compra = $(this).attr("id-compra");        

    $.ajax({
        url: "modal-detalhes-compra.php",
        method: "post",
        data: {
            id_compra: id_compra
        },
        success: function(data) {
            $("#detalhes-compra").html(data);
            $("#modal-detalhes-compra").modal("show");
        }
    });
});


// =======================================================
// Modal para a imagem da compra
// =======================================================

$(document).on('click', '.btn-imagem', function() {
    var id_compra = $(this).attr("id");          

    $.ajax({
        url: "modal-imagem-compra.php",
        method: "post",
        data: {
            id_compra: id_compra
        },
        success: function(data) {
            $("#imagem-compra").html(data);
            $("#modal-imagem-compra").modal("show");
        }
    });
});