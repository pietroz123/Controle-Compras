<?php

/**
 * Description of CompradorDAO
 *
 * @author Pietro
 */
class CompradorDAO {
    
    /**
     * Recupera as informações de um Comprador, dado seu ID
     * 
     * @param PDO $dbconn           : Conexão com o BD
     * @param int $id               : ID do Comprador
     * 
     * @return array $comprador     : Comprador encontrado
     */
    public static function recuperarComprador($dbconn, $id) {

        $sql = "SELECT * FROM compradores WHERE ID = $id";
    
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $comprador = $stmt->fetch();
        return $comprador;

    }

    
    // =======================================================
    // Funções de Atualização
    // =======================================================

    public function atualizarCPF($dbconn, $cpf, $email_sessao) {

        $sql = "UPDATE compradores c
                SET c.CPF = '{$cpf}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();

        return $resultado;

    }

    public function atualizarEmail($dbconn, $email, $email_sessao) {

        // Atualiza o Email na tabela Compradores
        $sql = "UPDATE compradores c
                SET c.Email = '{$email}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();

        // Atualiza o Email na tabela Usuarios
        $sql = "UPDATE usuarios u
                SET u.Email = '{$email}'
                WHERE u.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();

        return $resultado;

    }

    public function atualizarTelefone($dbconn, $telefone, $email_sessao) {

        $sql = "UPDATE compradores c
                SET c.Telefone = '{$telefone}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();

        return $resultado;

    }

    public function atualizarCidade($dbconn, $cidade, $email_sessao) {

        $sql = "UPDATE compradores c
                SET c.Cidade = '{$cidade}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();

        return $resultado;

    }

    public function atualizarEstado($dbconn, $estado, $email_sessao) {

        $sql = "UPDATE compradores c
                SET c.Estado = '{$estado}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();

        return $resultado;

    }

    public function atualizarCEP($dbconn, $cep, $email_sessao) {

        $sql = "UPDATE compradores c
                SET c.CEP = '{$cep}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();

        return $resultado;

    }

    public function atualizarEndereco($dbconn, $endereco, $email_sessao) {

        $sql = "UPDATE compradores c
                SET c.Endereco = '{$endereco}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();

        return $resultado;

    }
    
    
}
