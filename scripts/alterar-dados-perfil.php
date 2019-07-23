<?php

if (isset($_POST['submit-alteracoes'])) {

    include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/persistence/CompradorDAO.php';
    $cdao = new CompradorDAO();

    
    // Recupera o email da sessão
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
    $email_sessao   = $_SESSION['login-email'];

    
    // Alteração do CPF
    if (isset($_POST['cpf'])) {

        $cpf = $_POST['cpf'];

        if (!$cdao->atualizarCPF($dbconn, $cpf, $email_sessao)) {
            $_SESSION['danger'] = "Erro na alteração do CPF" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Email
    if (isset($_POST['email'])) {

        $email = $_POST['email'];
        
        if (!$cdao->atualizarEmail($dbconn, $email, $email_sessao)) {
            $_SESSION['danger'] = "Erro na alteração do Email do Usuário" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Telefone
    if (isset($_POST['telefone'])) {

        $telefone = $_POST['telefone'];

        if (!$cdao->atualizarTelefone($dbconn, $telefone, $email_sessao)) {
            $_SESSION['danger'] = "Erro na alteração do Telefone" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração da Cidade
    if (isset($_POST['cidade'])) {

        $cidade = $_POST['cidade'];

        if (!$cdao->atualizarCidade($dbconn, $cidade, $email_sessao)) {
            $_SESSION['danger'] = "Erro na alteração da Cidade" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Estado
    if (isset($_POST['estado'])) {

        $estado = $_POST['estado'];

        if (!$cdao->atualizarEstado($dbconn, $estado, $email_sessao)) {
            $_SESSION['danger'] = "Erro na alteração do Estado" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do CEP
    if (isset($_POST['cep'])) {

        $cep = $_POST['cep'];

        if (!$cdao->atualizarCEP($dbconn, $cep, $email_sessao)) {
            $_SESSION['danger'] = "Erro na alteração do CEP" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Endereço
    if (isset($_POST['endereco'])) {

        $endereco = $_POST['endereco'];

        if (!$cdao->atualizarEndereco($dbconn, $endereco, $email_sessao)) {
            $_SESSION['danger'] = "Erro na alteração do Endereço" . $dbconn->errorInfo();
            header("Location: ../perfil-usuario.php");
            die();
        }
    }


    $_SESSION['success'] = "Dados alterados com sucesso";
    header("Location: ../perfil-usuario.php");
    die();



}