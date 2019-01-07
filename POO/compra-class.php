<?php

class Compra {
    
    private $id;
    private $valor;
    private $data;
    private $observacoes;
    private $desconto;
    private $forma_pagamento;
    private $comprador_id;

    // Construtor
    function __construct($valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id) {
        $this->setValor($valor);
        $this->setData($data);
        $this->setObservacoes($observacoes);
        $this->setDesconto($desconto);
        $this->setFormaPagamento($forma_pagamento);
        $this->setCompradorID($comprador_id);
    }

    // Getters
    public function getID() {
        return $this->id;
    }
    public function getValor() {
        return $this->valor;
    }
    public function getData() {
        return $this->data;
    }
    public function getObservacoes() {
        return $this->observacoes;
    }
    public function getDesconto() {
        return $this->desconto;
    }
    public function getFormaPagamento() {
        return $this->forma_pagamento;
    }
    public function getCompradorID() {
        return $this->comprador_id;
    }

    // Setters
    public function setID($id) {
        $this->id = $id;
    }
    public function setValor($valor) {
        $this->valor = $valor;
    }
    public function setData($data) {
        $this->data = $data;
    }
    public function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }
    public function setDesconto($desconto) {
        $this->desconto = $desconto;
    }
    public function setFormaPagamento($forma_pagamento) {
        $this->forma_pagamento = $forma_pagamento;
    }
    public function setCompradorID($comprador_id) {
        $this->comprador_id = $comprador_id;
    }

}

