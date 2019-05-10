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

    $(document).on('click', '.notificacao-icone', function(e) {

        e.stopPropagation();
    
        abrirNotificacoes();
    });


    // =======================================================
    // Recupera as notificações em tempo real
    // =======================================================

    carregarNotificacoes();
    
});

// Função para abrir as notificações
function abrirNotificacoes() {
    var delay = $('.notificacoes-box').index() * 50 + 'ms';
    $('.notificacoes-box').css({
        '-webkit-transition-delay': delay,
        '-moz-transition-delay': delay,
        '-o-transition-delay': delay,
        'transition-delay': delay
    });
    $(".notificacoes-box").toggleClass("active");
}

function carregarNotificacoes() {

    $.ajax({
        url: '../scripts/recuperar-notificacoes.php',
        method: 'POST',
        data: {
            requisicao: "carregar-notificacoes"
        },
        datatype: 'html',
        success: function(retorno) {
            console.log('Success');
            console.log(retorno);
        },
        error: function(retorno) {
            console.log('Error');
            console.log(retorno);
        }
    });

    

}