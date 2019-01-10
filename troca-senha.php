<?php
    include("database/conexao.php");
?>

<?php
    mostra_alerta("danger");
?>

<?php

    // Inicia a sessao
    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }

    // Verifica se o botão de submit foi pressionado
    if (!isset($_POST['submit-troca-senha'])) {
        $_SESSION['danger'] = "Você não deu submit!";
        header("Location: index.php");
    }
    else {

        // Recupera os dados do formulário POST
        $seletor = $_POST['seletor'];
        $token = $_POST['token'];
        $nova_senha = $_POST['nova_senha'];
        $nova_senha_rep = $_POST['nova_senha_rep'];

        // Salva a URI caso haja erro no formulario de troca de senha
        $url = "criar-nova-senha.php?seletor=" . $seletor . "&token=" . $token;      


        // Verifica se existe algum campo em branco
        if (empty($nova_senha) || empty($nova_senha_rep)) {
            $_SESSION['danger'] = "Existem campos em branco";
            header("Location: " . $url);
            die();
        }
        // Verifica se as senhas são iguais
        elseif ($nova_senha != $nova_senha_rep) {
            $_SESSION['danger'] = "As senhas não são iguais";
            header("Location: " . $url);
            die();
        }

        // Data atual para verificar se a requisicao nao expirou
        $data_atual = date("U");


        $query = "SELECT * FROM recuperacao_senha WHERE seletor = ? AND expira >= ?;";
        $stmt = mysqli_stmt_init($conexao);
        if (!mysqli_stmt_prepare($stmt, $query)) {
            $_SESSION['danger'] = "Ocorreu um erro ao verificar os tokens.";
            header("Location: recuperacao-senha.php");
            die();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $seletor, $data_atual);
            mysqli_stmt_execute($stmt);

            $resultado = mysqli_stmt_get_result($stmt);
            $entrada = mysqli_fetch_assoc($resultado);
            if ($entrada == null) {
                $_SESSION['danger'] = "Não existem entradas para essa requisição. Favor requisitar novamente.";
                header("Location: recuperacao-senha.php");
                die();
            } else {

                // Converte o token para binario novamente
                $token_binario = hex2bin($token);
                $token_check = password_verify($token_binario, $entrada['Token']);

                if ($token_check === false) {
                    $_SESSION['danger'] = "Não foi possível verificar o token. Favor requisitar novamente.";
                    header("Location: recuperacao-senha.php");
                    die();
                } elseif ($token_check === true) {

                    $token_email = $entrada['Email'];
                    
                    $query = "SELECT * FROM usuarios WHERE email = ?;";
                    $stmt = mysqli_stmt_init($conexao);
                    if (!mysqli_stmt_prepare($stmt, $query)) {
                        $_SESSION['danger'] = "Erro ao preparar a busca pelo usuário.";
                        header("Location: recuperacao-senha.php");
                        die();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $token_email);
                        mysqli_stmt_execute($stmt);

                        $resultado = mysqli_stmt_get_result($stmt);
                        $entrada = mysqli_fetch_assoc($resultado);
                        if ($entrada == null) {
                            $_SESSION['danger'] = "Não existem entradas com este e-mail.";
                            header("Location: recuperacao-senha.php");
                            die();
                        } else {

                            // Atualiza a senha do usuario
                            $query = "UPDATE usuarios SET senha = ? WHERE email = ?;";
                            $stmt = mysqli_stmt_init($conexao);
                            if (!mysqli_stmt_prepare($stmt, $query)) {
                                $_SESSION['danger'] = "Ocorreu um erro ao trocar a senha.";
                                header("Location: recuperacao-senha.php");
                                die();
                            } else {
                                $hash_nova_senha = password_hash($nova_senha, PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt, "ss", $hash_nova_senha, $token_email);
                                mysqli_stmt_execute($stmt);

                                // Deleta todos os possiveis tokens ainda existentes e relacionados ao e-mail do usuario
                                $query = "DELETE FROM recuperacao_senha WHERE email = ?;";
                                $stmt = mysqli_stmt_init($conexao);
                                if (!mysqli_stmt_prepare($stmt, $query)) {
                                    $_SESSION['danger'] = "Ocorreu um erro ao deletar os tokens pre-existentes após a atualização da senha.";
                                    header("Location: index.php");
                                    die();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $token_email);
                                    mysqli_stmt_execute($stmt);

                                    $_SESSION['success'] = "Sua senha foi atualizada com sucesso e requisições pre-existentes foram removidas.";
                                    header("Location: index.php");
                                    die();

                                }
                            }

                        }
                    }
                }

            }

        }


    }