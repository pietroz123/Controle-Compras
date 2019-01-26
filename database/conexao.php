<?php

// $config = parse_ini_file('../private/config_compras.ini');

// $servidor   = $config['servidor'];
// $usuario    = $config['usuario'];
// $senha      = $config['senha'];
// $banco      = $config['banco'];

$servidor   = 'localhost';
$usuario    = 'root';
$senha      = '';
$banco      = 'my_controle_compras';

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Falha na Conexao: " . mysqli_connect_error());
}