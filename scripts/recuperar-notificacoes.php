<?php

// Verifica se existe uma requisição
if (isset($_POST['requisicao'])) {


    // Includes
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';


    switch ($_POST['requisicao']) {
        
        // Carregar as notificações na aba de notificações
        case 'carregarNotificacoes':
            # code...
            break;
        
        default:
            # code...
            break;
    }


}