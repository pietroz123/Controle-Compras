<?php

// Verifica se existe uma requisição
if (isset($_POST['requisicao'])) {


    // Includes
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-notificacoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';

	$retorno = '';

    switch ($_POST['requisicao']) {
        
        // Carregar as notificações na aba de notificações
        case 'carregar-notificacoes':
            
            $retorno = recuperar_notificacoes($conexao);
                
            echo json_encode($retorno);
            die();
            
            break;
        
        // Caso o usuário deseje aceitar a notificação
        case 'aceitar-notificacao':
            # code...
            die();
            
            break;

        // Caso o usuário deseje rejeitar a notificação
        case 'rejeitar-notificacao':
            # code...
            die();
            
            break;
        
        default:
            # code...
            break;
    }


}