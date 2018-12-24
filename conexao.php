<?php

include("compra-class.php");

class Conexao {

    var $servidor = "localhost";
    var $usuario = "root";
    var $senha = "";
    var $banco = "my_controle_compras";

    private static $mysqli;


    public function getConnection() {
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


    $conexao = mysqli_connect('localhost', 'root', '', 'my_controle_compras');

    if (!$conexao) {
        die("Falha na Conexao: " . mysqli_connect_error());
    }