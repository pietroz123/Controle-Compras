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
            
            // Recupera o id do grupo
            $id_grupo = $_POST['id_grupo'];

            if (aceitar_notificacao($conexao, $id_grupo)) {
                $_SESSION['success'] = "Convite aceito com sucesso!";
                header("Location: ../perfil-usuario.php#cartao-grupos-usuario");
            }
            else {
                $_SESSION['danger'] = "Não foi possível aceitar o convite!";
                header("Location: ../perfil-usuario.php");
            }

            die();
            
            break;

        // Caso o usuário deseje rejeitar a notificação
        case 'rejeitar-notificacao':
            
            // Recupera o id do grupo
            $id_grupo = $_POST['id_grupo'];

            if (rejeitar_notificacao($conexao, $id_grupo)) {
                $_SESSION['success'] = "Convite rejeitado com sucesso!";
                header("Location: ../perfil-usuario.php");
            }
            else {
                $_SESSION['danger'] = "Não foi possível rejeitar o convite!";
                header("Location: ../perfil-usuario.php");
            }

            die();
            
            break;
        
        default:
            # code...
            break;
    }


}