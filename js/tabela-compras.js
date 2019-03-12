
// =======================================================
// Função para reinicializar a DataTable
// =======================================================

function inicializaDataTable() {
    $('#tabela-compras').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ itens por página",
            "zeroRecords": "Nenhum item encontrado - desculpa",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum item encontrado",
            "infoFiltered": "(filtrado a partir de _MAX_ itens)",
            "search": "Buscar:",
            "emptyTable":     "Nenhum dado disponível na tabela",
            "loadingRecords": "Carregando...",
            "processing":     "Processando...",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Último",
                "next":       "Próximo",
                "previous":   "Anterior"
            }
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