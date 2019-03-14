
$(document).ready(function() {


    criaSelect2();


    // =======================================================
    // Design responsivo botões criar e recarregar
    // =======================================================
    $(window).resize(function() {
        if ($(window).width() <= 576) {
            $('.btn-criar-grupo').removeClass("mr-2");
            $('.btn-criar-grupo').addClass("mt-2");
            $('.btn-recarregar-grupos').addClass("mt-2");
        } else {
            $('.btn-criar-grupo').addClass("mr-2");
            $('.btn-criar-grupo').removeClass("mt-2");
            $('.btn-recarregar-grupos').removeClass("mt-2");
        }
    });


    $('#modal-criar-grupo').on('show.bs.modal', function(event) {
        // Recupera as informacoes do botao
        var botao = $(event.relatedTarget);
        var username = botao.data('username');

        var modal = $(this);
        modal.find('#criar-username').val(username);
    });

});


// =======================================================
// Funções dos grupos
// =======================================================

function formatarUsuario (usuario) {
    if (!usuario.id) {
        return usuario.text;
    }
    var $usuario = $(
        '<span><img src="scripts/icone.php?icone=' + usuario.text + '" class="img-usuario" style="height: 30px; width: 30px;"> ' + usuario.text + '</span>'
    );
    return $usuario;
};

function criaSelect2() {
    $('.input-usuario').select2({
        ajax: {
            url: "scripts/busca-usuario.php",
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
        templateResult: formatarUsuario
    });
}

function atualizaModalGrupos(retorno) {

    // Atualiza o html da pagina
    $('#membros-grupo').html(retorno);
                
    // Recupera informações do numero de membros na pagina
    var numero_membros = $("#numero").text();
    var nome_grupo = $('.titulo-membros').text();
    var td = $('td:contains("'+nome_grupo+'")');
    var tr = td.parent();
    var td_numero = tr.children('.numero-membros-grupo');

    // Atualiza o numero de membros na visualização
    td_numero.text(numero_membros);

    // Cria o input select2
    criaSelect2();
}


/* ===========================================================================================================
===================================== PREENCHE MODAL MEMBROS GRUPO COM AJAX ==================================
============================================================================================================== */

$(document).on('click', '.btn-membros', function() {
    var id_grupo = $(this).attr("id");
    var username = $(this).attr("username");            

    $.ajax({
        url: "modal-membros-grupo.php",
        method: "post",
        data: {
            id_grupo: id_grupo,
            username: username
        },
        success: function(data) {
            $("#membros-grupo").html(data);
            $("#modal-membros-grupo").modal("show");
            
            // Cria o input select2
            criaSelect2();
        }
    });
});


/* ===========================================================================================================
========================================= RECARREGA OS GRUPOS COM AJAX =======================================
============================================================================================================== */

$(".btn-recarregar-grupos").click(function() {
    var icone = document.querySelector("#icone-recarregar");
    var username = $(this).attr('username-usuario');
    
    icone.classList.add('fa-spin');

    setTimeout(function() {
        icone.classList.remove('fa-spin');
    }, 1000);

    $.ajax({
        url: "scripts/recarregar-grupos.php",
        method: "post",
        data: {
            username: username
        },
        success: function(retorno) {
            $('#container-tabela-grupos').html(retorno);                    
        }
    });

});



/* ===========================================================================================================
===================================== REALIZA REMOÇÃO DE UM MEMBRO NO GRUPO ==================================
============================================= E RECARREGA O MODAL ============================================
============================================================================================================== */

$(document).on('mouseover', '.btn-remover-membro', function(){
    
    var id_grupo = $(this).attr("id-grupo");
    var username_usuario = $(this).attr('username-usuario');
    var usuario = $(this).attr("username-membro");

    
    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        onConfirm: function() {
            // Caso o usuário pressione 'Sim'
            $.ajax({
                url: "modal-membros-grupo.php",
                method: "post",
                data: {
                    remover: "sim",
                    id_grupo: id_grupo,
                    usuario: usuario,
                    username: username_usuario
                },
                dataType: "html",
                success: function(retorno) {
                    
                    // Atualiza as informações dos grupos
                    atualizaModalGrupos(retorno);

                }
            });
        },
        onCancel: function() {
            // Caso o usuário pressione 'Não'
        }
        // other options
    });


});


/* ===========================================================================================================
====================================== REALIZA ADIÇÃO MAIS MEMBROS NO GRUPO ==================================
============================================= E RECARREGA O MODAL ============================================
============================================================================================================== */

$(document).on('click', '.btn-adicionar-membros', function() {

    // Recupera os IDs dos usuários a serem adicionados
    var select = $('#select2-usuarios').val();
    var id_grupo = $(this).attr('id-grupo');        
    var username = $(this).attr('username-usuario');

    if (select) {
        $.ajax({
            url: "modal-membros-grupo.php",
            method: "post",
            data: {
                adicionar: "sim",
                id_grupo: id_grupo,
                ids_adicionar: select,
                username: username
            },
            dataType: "html",
            success: function(retorno) {

                // Atualiza as informações dos grupos
                atualizaModalGrupos(retorno);

            }
        });
    }
    
    
});


/* ===========================================================================================================
========================================== BOTÃO PARA SAIR DO GRUPO ==========================================
============================================================================================================== */

$(document).on('click', '.btn-sair-grupo', function() {

    var id_grupo = $(this).attr('id-grupo');        
    var username = $(this).attr('username-usuario');

    $.ajax({
        url: "modal-membros-grupo.php",
        method: "post",
        dataType: "json",
        data: {
            sair: "sim",
            id_grupo: id_grupo,
            usuario: username
        },
        success: function(retorno) {
            if (retorno.quantidade == 0) {
                $.post('scripts/remover-grupo.php', {
                    remover_grupo: "sim",
                    id: id_grupo
                }, function(data, status) {
                    location.href = "perfil-usuario.php";
                });
            }
            else {
                location.href = "perfil-usuario.php";
            }
        }
    });

});