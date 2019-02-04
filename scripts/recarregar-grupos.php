<?php

if (isset($_POST['username'])) {
    
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';        
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    
    $grupos = recuperar_grupos($conexao, $_POST['username']);
    $retorno = '';

    foreach ($grupos AS $grupo) { 
        $retorno .= '<tr class="row">
            <td class="col-sm-4">'.$grupo['Nome'].'</td>
            <td class="col-sm-3">'.date("d/m/Y h:m", strtotime($grupo['Data_Criacao'])).'</td>
            <td class="col-sm-3">'.$grupo['Numero_Membros'].'</td>
            <td class="col-sm-2">
                <button class="btn btn-info botao-pequeno btn-membros" id="'.$grupo['ID'].'" username="'.$_POST['username'].'">Membros</button>
            </td>
        </tr>';

    }
    echo $retorno;
}