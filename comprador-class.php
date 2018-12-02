<?php

class Comprador {

    private $id;
    private $nome;
    private $cidade;
    private $estado;
    private $endereco;
    private $cep;
    private $cpf;
    private $email;
    private $telefone;

    // Construtor
    function __construct($nome, $cidade, $estado, $endereco, $cep, $cpf, $email, $telefone) {
        $this->setNome($nome);
        $this->setCidade($cidade);
        $this->setEstado($estado);
        $this->setEndereco($endereco);
        $this->setCEP($cep);
        $this->setCPF($cpf);
        $this->setEmail($email);
        $this->setTelefone($telefone);
    }


    // Getters
    public function getID() {
        return $this->id;
    }
    public function getNome() {
        return $this->nome;
    }
    public function getCidade() {
        return $this->cidade;
    }
    public function getEstado() {
        return $this->estado;
    }
    public function getEndereco() {
        return $this->endereco;
    }
    public function getCEP() {
        return $this->cep;
    }
    public function getCPF() {
        return $this->cpf;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getTelefone() {
        return $this->telefone;
    }

    // Setters
    public function setID($id) {
        $this->id = $id;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }
    public function setEstado($estado) {
        $this->estado = $estado;
    }
    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }
    public function setCEP($cep) {
        $this->cep = $cep;
    }
    public function setCPF($cpf) {
        $this->cpf = $cpf;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }



}