<?php

include("compra-class.php");

class Conexao {

    var $servidor = "localhost";
    var $usuario = "root";
    var $senha = "";
    var $banco = "my_controle_compras";

    private $mysqli;



    public function open() {
        $this->mysqli = new mysqli($this->servidor, $this->usuario, $this->senha, $this->banco);
    }
    public function close() {
        $this->mysqli->close();
    }

    public function adicionar_compra(Compra $c) {
        $query = "insert into compras (valor, data, recebido, observacoes, desconto, forma_pagamento, comprador_id) values ({$c->getValor()}, '{$c->getData()}', {$c->getRecebido()}, '{$c->getObservacoes()}', {$c->getDesconto()}, '{$c->getFormaPagamento()}', {$c->getCompradorID()});";
        return mysqli_query($this->mysqli, $query);
    }

}


    $conexao = mysqli_connect('localhost', 'root', '', 'my_controle_compras');