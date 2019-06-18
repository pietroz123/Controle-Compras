/// <reference path='../lib/jquery/js/jquery-latest.js' />
/// <reference path='../lib/mdbootstrap/js/datatables.js' />

// =======================================================
// Função para reinicializar a DataTable
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


// =======================================================
// Inicializa a tabela de dados
// =======================================================

$(document).ready(function () {

    inicializaDataTable();
});



// ======================================================================================================================================
// ==================================== AO CLICAR EM UM GRUPO, RECUPERA AS COMPRAS DAQUELE GRUPO ========================================
// ======================================================================================================================================

$('.link-cartao-grupo').click(function () {
    var id_grupo = $(this).attr('id-grupo');

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
                "id_grupo": id_grupo
            }
        },
        "columns": [
            {
                "name": "id",
                "className": "t-id"
            },
            {
                "name": "data",
                "className": "t-data"
            },
            {
                "name": "observacoes",                
                "className": "t-observacoes"
            },
            {
                "name": "valor",
                "className": "t-valor"
            },
            {
                "name": "desconto",
                "className": "t-desconto"
            },
            {
                "name": "forma_pagamento",
                "className": "t-forma"
            },
            {
                "name": "nome_comprador",
                "className": "t-nome"
            }
        ],
        "order": [[ 1, "desc" ]]    // Ordena por Data
    });

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
                "todas": "sim"
            }
        },
        "columns": [
            {
                "name": "id",
                "className": "t-id"
            },
            {
                "name": "data",
                "className": "t-data"
            },
            {
                "name": "observacoes",                
                "className": "t-observacoes"
            },
            {
                "name": "valor",
                "className": "t-valor"
            },
            {
                "name": "desconto",
                "className": "t-desconto"
            },
            {
                "name": "forma_pagamento",
                "className": "t-forma"
            },
            {
                "name": "nome_comprador",
                "className": "t-nome"
            }
        ],
        "order": [[ 1, "desc" ]]    // Ordena por Data
    });

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

$(document).on('click', '.btn-detalhes', function() {
    var id_compra = $(this).attr("id");        

    $.ajax({
        url: "modal-detalhes-produto.php",
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