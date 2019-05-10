<?php

// Verifica se existe uma requisição
if (isset($_POST['requisicao'])) {


    // Includes
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';

	$retorno = '';

    switch ($_POST['requisicao']) {
        
        // Carregar as notificações na aba de notificações
        case 'carregarNotificacoes':
            
            // Recupera as notificações
            $sql = "SELECT * FROM grupo_usuarios WHERE Autorizado = 0 AND username = ?";
            $stmt = mysqli_stmt_init($conexao);
            
            if (!mysqli_stmt_prepare($stmt, $sql)) {
            	$retorno .= '<div class="alert alert-danger">Ocorreu um erro ao recuperar as notificações de grupos.</dia>';
                echo $retorno;
                die();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['login-username']);
                mysqli_stmt_execute($stmt);
				
				$resultado = mysqli_stmt_get_result($stmt);
                $notificacoes = array();
	
	            while ($notificacao = mysqli_fetch_assoc($resultado)) {
	                
	            }
	            
	            echo $retorno;
	            die();
            }
            
            break;
        
        default:
            # code...
            break;
    }


}