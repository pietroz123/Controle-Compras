<?php

/**
 * Description of Compra
 *
 * @author Pietro
 */
class Compra {
    
    private $id;
    private $valor;
    private $data;
    private $observacoes;
    private $desconto;
    private $forma_pagamento;
    private $imagem;
    private $id_comprador;
    
    function getId() {
        return $this->id;
    }

    function getValor() {
        return $this->valor;
    }

    function getData() {
        return $this->data;
    }

    function getObservacoes() {
        return $this->observacoes;
    }

    function getDesconto() {
        return $this->desconto;
    }

    function getForma_pagamento() {
        return $this->forma_pagamento;
    }

    function getImagem() {
        return $this->imagem;
    }

    function getId_comprador() {
        return $this->id_comprador;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    function setDesconto($desconto) {
        $this->desconto = $desconto;
    }

    function setForma_pagamento($forma_pagamento) {
        $this->forma_pagamento = $forma_pagamento;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    function setId_comprador($id_comprador) {
        $this->id_comprador = $id_comprador;
    }
    
}
