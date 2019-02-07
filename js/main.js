$(document).ready(function() {

    
    /* ==============================================================================================================
    ====================================== FUNÇÕES DE FORMATAÇÃO DO FORM DE CADASTRO ================================
    ============================================================================================================== */


    $("#form-cadastro").ready(function() {
        
        $("#input-cpf").mask('000.000.000-00');             /* Formata o CPF */
        $("#input-cep").mask('00000-000');                  /* Formata o CEP */
        $('#input-telefone').mask('(00) 00000-0000');       /* Formata o telefone */
        $('#input-telefone-res').mask('(00) 0000-0000');       /* Formata o residencial */

        new Awesomplete('input[type="email"]', {
            list: ["terra.com.br", "gmail.com", "hotmail.com", "yahoo.com", "outlook.com"],
            data: function (text, input) {
                return input.slice(0, input.indexOf("@")) + "@" + text;
            },
            filter: Awesomplete.FILTER_STARTSWITH
        });

    });


    /* ================================================================================================================
    ======================================= APLICA CSS NA BARRA DE NAVEGAÇÃO ==========================================
    ================================================================================================================ */

    var urlPagina = window.location.pathname.split('/')[1];
    $('.navbar-nav > li > a[href="'+urlPagina+'"]').parent().addClass('active special-color');

    
});