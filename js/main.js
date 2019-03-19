$(document).ready(function() {

    // =======================================================
    // APLICA CSS NA BARRA DE NAVEGAÇÃO E RODAPÉ
    // =======================================================

    var urlPagina = window.location.pathname.split('/')[1];
    $('.navbar-nav > li > a[href="'+urlPagina+'"]').parent().addClass('active special-color');
    $('.footer-nav-item[href="'+urlPagina+'"]').addClass('active');
    
});