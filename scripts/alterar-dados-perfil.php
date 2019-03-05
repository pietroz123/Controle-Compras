<?php

if (isset($_POST['submit-alteracoes'])) {

    $cpf        = $_POST['cpf'];
    $email      = $_POST['email'];
    $telefone   = $_POST['telefone'];
    $cidade     = $_POST['cidade'];
    $estado     = $_POST['estado'];
    $cep        = $_POST['cep'];
    $endereco   = $_POST['endereco'];

    echo $cpf . '<br>';
    echo $email . '<br>';
    echo $telefone . '<br>';
    echo $cidade . '<br>';
    echo $estado . '<br>';
    echo $cep . '<br>';
    echo $endereco . '<br>';


}