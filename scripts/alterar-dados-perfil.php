<?php

if (isset($_POST['submit-alteracoes'])) {

    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';

    
    // Recupera o email da sessão
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
    $email_sessao   = $_SESSION['login-email'];

    
    // Alteração do CPF
    if (isset($_POST['cpf'])) {

        $sql = "UPDATE compradores c
                SET c.CPF = '{$cpf}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do CPF" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Email
    if (isset($_POST['email'])) {
        
        $sql = "UPDATE compradores c
                SET c.Email = '{$email}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Email do Comprador" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }

        $sql = "UPDATE usuarios u
                SET u.Email = '{$email}'
                WHERE u.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Email do Usuário" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Telefone
    if (isset($_POST['telefone'])) {

        $sql = "UPDATE compradores c
                SET c.Telefone = '{$telefone}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Telefone" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração da Cidade
    if (isset($_POST['cidade'])) {

        $sql = "UPDATE compradores c
                SET c.Cidade = '{$cidade}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração da Cidade" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Estado
    if (isset($_POST['estado'])) {

        $sql = "UPDATE compradores c
                SET c.Estado = '{$estado}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Estado" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do CEP
    if (isset($_POST['cep'])) {

        $sql = "UPDATE compradores c
                SET c.CEP = '{$cep}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do CEP" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Endereço
    if (isset($_POST['endereco'])) {

        $sql = "UPDATE compradores c
                SET c.Endereco = '{$endereco}'
                WHERE c.Email = '{$email_sessao}'";
        $stmt = $dbconn->prepare($sql);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Endereço" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }


    $_SESSION['success'] = "Dados alterados com sucesso";
    header("Location: ../perfil-usuario.php");
    die();



}