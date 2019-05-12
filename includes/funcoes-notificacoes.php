<?php

date_default_timezone_set('America/Sao_Paulo');

// Recupera as notificações do usuário logado
function recuperar_notificacoes($conexao) {
    // Recupera as notificações
    $sql = "SELECT * FROM grupo_usuarios WHERE Autorizado = 0 AND username = ?";
    $stmt = mysqli_stmt_init($conexao);

    $retorno = array();
    $retorno['html'] = '';
    $retorno['qtd'] = 0;
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $retorno['html'] .= '<div class="alert alert-danger">Ocorreu um erro ao recuperar as notificações de grupos.</div>';
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

            // Notificações
            $retorno['html'] .= '
                <div class="notif clearfix">
                    <div class="notification group">
                        <span class="notif-text"><b>'.$convidado_por_nome.'(<a href="#!">@'.$convidado_por_username.'</a>)</b> te convidou para o grupo <b>'.$nome_grupo.'</b>.</span>
                        <div class="notif-time">'.date("d/m/Y H:i", strtotime($convidado_em)).'</div>
                        <span class="float-left">Deseja aceitar?</span>
                        <div class="float-right">
                            <div class="btns-decisao">
                                <form action="includes/logica-notificacoes.php" method="POST">
                                    <input type="hidden" name="requisicao" value="aceitar-notificacao">
                                    <input type="hidden" name="id_grupo" value="'.$notificacao['ID_Grupo'].'">
                                    <button type="submit" class="btn-notificacao"><span class="badge badge-pill badge-primary">Sim</span></button>
                                </form>
                                <form action="includes/logica-notificacoes.php" method="POST">
                                    <input type="hidden" name="requisicao" value="rejeitar-notificacao">
                                    <input type="hidden" name="id_grupo" value="'.$notificacao['ID_Grupo'].'">
                                    <button type="submit" class="btn-notificacao"><span class="badge badge-pill badge-danger">Não</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
        }

        // Caso não existam notificações
        if ($retorno['qtd'] == 0) {
            $retorno['html'] .= '<div class="alert alert-info">Nenhuma notificação no momento.</div>';
        }
    }

    return $retorno;
}


// Para aceitar um convite
function aceitar_notificacao($conexao, $id_grupo) {

    $sql = "UPDATE grupo_usuarios SET Autorizado = 1, Membro_Desde = '".date("Y-m-d H:i:s")."' WHERE ID_Grupo = {$id_grupo} AND Username = '{$_SESSION['login-username']}'";
    return mysqli_query($conexao, $sql);

}


// Para rejeitar um convite
function rejeitar_notificacao($conexao, $id_grupo) {
 
    $sql = "DELETE FROM grupo_usuarios WHERE ID_Grupo = {$id_grupo} AND Username = '{$_SESSION['login-username']}'";
    return mysqli_query($conexao, $sql);
    
}