<?php

include("compra-class.php");


$config = parse_ini_file('../private_compras/config.ini');

$servidor   = $config['servidor'];
$usuario    = $config['usuario'];
$senha      = $config['senha'];
$banco      = $config['banco'];


class Conexao {

    var $servidor;
    var $usuario;
    var $senha;
    var $banco;

    private static $mysqli;

    public function getConnection() {

        $config = parse_ini_file('../private_compras/config.ini');
        $this->servidor   = $config['servidor'];
        $this->usuario    = $config['usuario'];
        $this->senha      = $config['senha'];
        $this->banco      = $config['banco'];

        $mysqli = new mysqli($this->servidor, $this->usuario, $this->senha, $this->banco);
        return $mysqli;
    }
    public function close() {
        $this->mysqli->close();
    }


}

class OperacoesBD {


    public function adicionar_compra(mysqli $conn, Compra $c) {
        $query = "INSERT INTO compras (valor, data, observacoes, desconto, forma_pagamento, comprador_id) VALUES ({$c->getValor()}, '{$c->getData()}', '{$c->getObservacoes()}', {$c->getDesconto()}, '{$c->getFormaPagamento()}', {$c->getCompradorID()});";

        return mysqli_query($conn, $query);
    }

    public function adicionar_comprador(mysqli $conn, Comprador $c) {
        $query = "INSERT INTO compradores (nome, cidade, estado, endereco, cep, cpf, email, telefone) VALUES ('{$c->getNome()}', '{$c->getCidade()}', '{$c->getEstado()}', '{$c->getEndereco()}', '{$c->getCEP()}', '{$c->getCPF()}', '{$c->getEmail()}', '{$c->getTelefone()}');";
        
        return mysqli_query($conn, $query);
    }

    
}

    // Variáveis "globais"
    $conn = new Conexao();
    $mysqli = $conn->getConnection();

    $op = new OperacoesBD();


    $conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

    if (!$conexao) {
        die("Falha na Conexao: " . mysqli_connect_error());
    }