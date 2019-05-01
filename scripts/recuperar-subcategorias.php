<?php

include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-categorias.php';

if (isset($_POST['categoria'])) {

    $cat =  $_POST['categoria'];

    $subcat = recuperar_subcategorias($conexao, $cat);

    $retorno = '';
    foreach ($subcat as $subcategoria) {
        $retorno .= '<option value="'.$subcategoria['ID_Subcategoria'].'">'.$subcategoria['Nome_Subcategoria'].'</option>';
    }

    echo $retorno;

}