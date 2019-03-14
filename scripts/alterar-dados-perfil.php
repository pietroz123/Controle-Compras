<?php

if (isset($_POST['submit-alteracoes'])) {

    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';

    
    // Recupera o email da sessão
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
    $email_sessao   = $_SESSION['login-email'];

    
    // Alteração do CPF
    if (isset($_POST['cpf'])) {
        $cpf        = mysqli_real_escape_string($conexao, $_POST['cpf']);

        $sql = "UPDATE compradores c
                SET c.CPF = '{$cpf}'
                WHERE c.Email = '{$email_sessao}'";
        $resultado = mysqli_query($conexao, $sql);
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do CPF" . mysqli_error($conexao);
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Email
    if (isset($_POST['email'])) {
        $email      = mysqli_real_escape_string($conexao, $_POST['email']);
        
        $sql = "UPDATE compradores c
                SET c.Email = '{$email}'
                WHERE c.Email = '{$email_sessao}'";
        $resultado = mysqli_query($conexao, $sql);
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Email do Comprador" . mysqli_error($conexao);
            header("Location: ../perfil-usuario.php");
            die();
        }

        $sql = "UPDATE usuarios u
                SET u.Email = '{$email}'
                WHERE u.Email = '{$email_sessao}'";
        $resultado = mysqli_query($conexao, $sql);
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Email do Usuário" . mysqli_error($conexao);
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Telefone
    if (isset($_POST['telefone'])) {
        $telefone   = mysqli_real_escape_string($conexao, $_POST['telefone']);

        $sql = "UPDATE compradores c
                SET c.Telefone = '{$telefone}'
                WHERE c.Email = '{$email_sessao}'";
        $resultado = mysqli_query($conexao, $sql);
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Telefone" . mysqli_error($conexao);
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração da Cidade
    if (isset($_POST['cidade'])) {
        $cidade     = mysqli_real_escape_string($conexao, $_POST['cidade']);

        $sql = "UPDATE compradores c
                SET c.Cidade = '{$cidade}'
                WHERE c.Email = '{$email_sessao}'";
        $resultado = mysqli_query($conexao, $sql);
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração da Cidade" . mysqli_error($conexao);
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Estado
    if (isset($_POST['estado'])) {
        $estado     = mysqli_real_escape_string($conexao, $_POST['estado']);

        $sql = "UPDATE compradores c
                SET c.Estado = '{$estado}'
                WHERE c.Email = '{$email_sessao}'";
        $resultado = mysqli_query($conexao, $sql);
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Estado" . mysqli_error($conexao);
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do CEP
    if (isset($_POST['cep'])) {
        $cep        = mysqli_real_escape_string($conexao, $_POST['cep']);

        $sql = "UPDATE compradores c
                SET c.CEP = '{$cep}'
                WHERE c.Email = '{$email_sessao}'";
        $resultado = mysqli_query($conexao, $sql);
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do CEP" . mysqli_error($conexao);
            header("Location: ../perfil-usuario.php");
            die();
        }
    }
    
    // Alteração do Endereço
    if (isset($_POST['endereco'])) {
        $endereco   = mysqli_real_escape_string($conexao, $_POST['endereco']);

        $sql = "UPDATE compradores c
                SET c.Endereco = '{$endereco}'
                WHERE c.Email = '{$email_sessao}'";
        $resultado = mysqli_query($conexao, $sql);
        
        if (!$resultado) {
            $_SESSION['danger'] = "Erro na alteração do Endereço" . mysqli_error($conexao);
            header("Location: ../perfil-usuario.php");
            die();
        }
    }


    $_SESSION['success'] = "Dados alterados com sucesso";
    header("Location: ../perfil-usuario.php");
    die();



}