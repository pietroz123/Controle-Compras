<?php

// Verifica se existe uma requisição
if (isset($_POST['requisicao'])) {


    // Includes
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';

	$retorno = '';

    switch ($_POST['requisicao']) {
        
        // Carregar as notificações na aba de notificações
        case 'carregar-notificacoes':
            
            // Recupera as notificações
            $sql = "SELECT * FROM grupo_usuarios WHERE Autorizado = 0 AND username = ?";
            $stmt = mysqli_stmt_init($conexao);

            $retorno = array();
            $retorno['html'] = '';
            $retorno['qtd'] = 0;
            
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                $retorno['html'] .= '<div class="alert alert-danger">Ocorreu um erro ao recuperar as notificações de grupos.</dia>';
                echo json_encode($retorno);
                die();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['login-username']);
                mysqli_stmt_execute($stmt);
                
                $resultado = mysqli_stmt_get_result($stmt);
                $notificacoes = array();

                while ($notificacao = mysqli_fetch_assoc($resultado)) {

                    // Incrementa o número de notificações
                    $retorno['qtd']++;
                    
                    // Quem convidou
                    $convidado_por = join_usuario_comprador_username($conexao, $notificacao['Convidado_Por']);
                    $convidado_por_nome = $convidado_por['Nome'];
                    $convidado_por_nome = explode(' ', $convidado_por_nome)[0];
                    $convidado_por_username = $convidado_por['Usuario'];

                    // Para qual grupo
                    $grupo = recuperar_grupo($conexao, $notificacao['ID_Grupo']);
                    $nome_grupo = $grupo['Nome'];

                    // Quando
                    $convidado_em = $notificacao['Convidado_Em'];

                    $retorno['html'] .= '
                        <div class="notif clearfix">
                            <div class="float-left">
                                <img src="img/group.png" class="notif-icon">
                            </div>
                            <div class="float-right">
                                <span class="notif-text"><b>'.$convidado_por_nome.'(<a href="#!">@'.$convidado_por_username.'</a>)</b> te convidou para o grupo <b>'.$nome_grupo.'</b>.</span>
                                <div class="notif-time">'.date("d/m/Y H:i", strtotime($convidado_em)).'</div>
                                <div>
                                    <span class="float-left">Deseja aceitar?</span>
                                    <div class="float-right">
                                        <a href="#!">
                                            <span class="badge badge-pill badge-primary">Sim</span>
                                        </a>
                                        <a href="#!">
                                            <span class="badge badge-pill badge-danger">Não</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
                
                echo json_encode($retorno);
                die();
            }
            
            break;
        
        default:
            # code...
            break;
    }


}