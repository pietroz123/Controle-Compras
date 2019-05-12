<?php

if (isset($_POST['username'])) {
    
    
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';        
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    

    $grupos = recuperar_grupos($conexao, $_POST['username']);
    $retorno = '';


    if (count($grupos) > 0) {

        $retorno = '
        <h6 class="mb-3">Meus Grupos</h6>
        <table class="table table-hover table-grupos" id="tabela-grupos">
            <thead style="font-weight: bold;">
                <tr>
                    <th class="thead-grupos">Nome</th>
                    <th class="thead-grupos">Data Criação</th>
                    <th class="thead-grupos">Número Membros</th>
                    <th class="thead-grupos">Visualizar</th>
                </tr>
            </thead>
            <tbody id="grupos-usuario">';

        foreach ($grupos AS $grupo) {

            $retorno .= '
                <tr>
                    <td>'.$grupo['Nome'].'</td>
                    <td>'.date("d/m/Y h:m", strtotime($grupo['Data_Criacao'])).'</td>
                    <td>'.$grupo['Numero_Membros'].'</td>
                    <td>
                        <button class="btn btn-info botao-pequeno btn-membros" id="'.$grupo['ID'].'" username="'.$_POST['username'].'">Membros</button>
                    </td>
                </tr>';
        }

        $retorno .= '</tbody>';

    }
    else {
        
        $retorno .= '<h6 class="mb-3">Meus Grupos</h6><div class="alert alert-info" role="alert">Você não está em nenhum grupo.</div>';
    }

    $retorno .= '</table>';

    echo $retorno;
}