/// <reference path='../lib/jquery/js/jquery-latest.js' />
/// <reference path='../lib/mdbootstrap/js/datatables.js' />

// =======================================================
// Função para reinicializar a DataTable
// =======================================================

function inicializaDataTable() {
    $('#tabela-compras').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
        },
        "order": [[ 1, "desc" ]]    // Ordena por Data
    });
    $('.dataTables_length').addClass('bs-select');
}


// =======================================================
// Inicializa a tabela de dados
// =======================================================

$(document).ready(function () {

    inicializaDataTable();
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