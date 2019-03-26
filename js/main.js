$(document).ready(function() {

    // =======================================================
    // APLICA CSS NA BARRA DE NAVEGAÇÃO E RODAPÉ
    // =======================================================

    var urlPagina = window.location.pathname.split('/')[1];
    $('.navbar-nav > li > a[href="'+urlPagina+'"]').parent().addClass('active special-color');
    $('.footer-nav-item[href="'+urlPagina+'"]').addClass('active');


    // =======================================================
    // Efeito de Scroll
    // =======================================================

    var url = window.location.href;
    var id = url.substring(url.lastIndexOf("#") + 1);
    

    if (id == "cartao-grupos-usuario" || id == "cartao-requisicoes" || id == "cartao-backups" || id == "container-tabela-grupos" || id == "tabela-compras" || id == "cartao-grupos-usuario") {

        // Scroll até a tabela de compras
        $('html, body').animate({
            scrollTop: $("#" + id).offset().top - 200
        }, 1500);


    }
    
});