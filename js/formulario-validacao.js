$(document).ready(function() {


    // =======================================================
    // Validação Geral
    // =======================================================

    $('#btn-adicionar').click(function(e) {


        // Recupera os inputs
        var in_observacoes      = $('#input-obs');              // retorna _ se vazio
        var in_categorias       = $('#select-categorias');      // retorna _ se vazio
        var in_valor            = $('#input-valor');            // retorna _ se vazio
        var in_desconto         = $('#input-desconto');         // retorna _ se vazio
        var in_comprador        = $('#select-comprador');       // retorna _ se vazio


        // Remove qualquer mensagem de erro para nova verificação
        $('.erro').remove();
        in_observacoes.removeClass('not-valid');
        in_categorias.parent().find('.select2-selection').removeClass('not-valid');
        in_valor.removeClass('not-valid');
        in_desconto.removeClass('not-valid');
        in_comprador.parent().find('.select2-selection').removeClass('not-valid');


        // Validações

        if (in_observacoes.val() == "") {
            in_observacoes.addClass('not-valid');
            $('<span class="erro font-small">Este campo é obrigatório</span>').insertAfter(in_observacoes);
        }
        
        if (in_categorias.val() == "") {
            in_categorias.parent().find('.select2-selection').addClass('not-valid');
            $('<span class="erro font-small">Este campo é obrigatório</span>').insertAfter(in_categorias);
        }

        if (in_valor.val() == "") {
            in_valor.addClass('not-valid');
            $('<span class="erro font-small">Este campo é obrigatório</span>').insertAfter(in_valor);
        }

        if (in_desconto.val() == "") {
            in_desconto.addClass('not-valid');
            $('<span class="erro font-small">Este campo é obrigatório</span>').insertAfter(in_desconto);
        }

        if (in_comprador.val() == "") {
            in_comprador.parent().find('.select2-selection').addClass('not-valid');
            $('<span class="erro font-small">Este campo é obrigatório</span>').insertAfter(in_comprador);
        }


        let numInvalid = $('.not-valid').length;
        if (numInvalid != 0) {

            // Previne o submit do formulário
            e.preventDefault();
        
            // Scroll para o Primeiro elemento inválido
            let primeiro = $('.erro').eq(0).parent().children('input, select');
            $([document.documentElement, document.body]).animate({
                scrollTop: primeiro.offset().top - 120
            }, 500);
        }
        

    });


    // =======================================================
    // Validação do INPUT de Observações
    // =======================================================

    $('#input-obs').keyup(function() {

        if ($(this).val().length >= 4) {

            $(this).removeClass('not-valid');
            $(this).addClass('valid');
            $(this).parent().children('.erro').remove();

        }
        else {
            
            $(this).removeClass('valid');
            $(this).addClass('not-valid');
            $(this).parent().children('.erro').remove();
            $('<span class="erro font-small">Mínimo de 4 caracteres</span>').insertAfter($(this));
            
        }

    });

    // =======================================================
    // Validação do INPUT de Categorias
    // =======================================================
    
    $('#select-categorias, #select-comprador').change(function() {

        if ($(this).val() != "") {

            $(this).parent().find('.select2-selection').removeClass('not-valid');
            $(this).parent().find('.select2-selection').addClass('valid');
            $(this).parent().children('.erro').remove();
            
        }
        else {
            
            $(this).parent().find('.select2-selection').removeClass('valid');
            $(this).parent().find('.select2-selection').addClass('not-valid');
            $(this).parent().children('.erro').remove();
            $('<span class="erro font-small">Este campo é obrigatório</span>').insertAfter($(this));
            
        }

    });

    // =======================================================
    // Validação do INPUT de Valor
    // =======================================================

    $('#input-valor').keyup(function() {

        if ($(this).val() != "") {
        
            $(this).removeClass('not-valid');
            $(this).addClass('valid');
            $(this).parent().children('.erro').remove();
        
        }
        else {

            $(this).removeClass('valid');
            $(this).addClass('not-valid');
            $(this).parent().children('.erro').remove();
            $('<span class="erro font-small">Digite um número</span>').insertAfter($(this));

        }

    });

});