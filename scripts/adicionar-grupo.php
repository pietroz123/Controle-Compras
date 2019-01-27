<?php

    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';

    if (isset($_POST['submit-criar-grupo'])) {

        if (isset($_POST['usernames'])) {

            if (!empty($_POST['usernames'])) {

                if (isset($_POST['nome-grupo'])) {

                    if (!empty($_POST['nome-grupo'])) {

                        /* Podemos inserir o grupo */

                        // ======== INSERÇÃO DO GRUPO =========
                        $nome_grupo = $_POST['nome-grupo'];
                        $sql = "INSERT INTO grupos (nome) VALUES (?)";
                        $stmt = mysqli_stmt_init($conexao);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            $_SESSION['danger'] = "Ocorreu um erro na inserção do grupo.";
                            header("Location: ../perfil-usuario.php");
                            die();
                        } else {
                            mysqli_stmt_bind_param($stmt, "s", $nome_grupo);
                            mysqli_stmt_execute($stmt);
                            // Sucesso
                        }

                        // ======== INSERÇÃO DOS USUÁRIOS ========
                        $usuarios = $_POST['usernames'];
                        $id_grupo = mysqli_stmt_insert_id($stmt);
                        foreach ($usuarios as $usuario) {
                            $sql = "INSERT INTO grupo_usuarios (id_grupo, username) VALUES (?, ?)";
                            $stmt = mysqli_stmt_init($conexao);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                $_SESSION['danger'] = "Ocorreu um erro na inserção dos usuários no grupo.";
                                header("Location: ../perfil-usuario.php");
                                die();
                            } else {
                                mysqli_stmt_bind_param($stmt, "is", $id_grupo, $usuario);
                                mysqli_stmt_execute($stmt);
                                // Sucesso
                            }
                        }


                        $_SESSION['success'] = "Criação do grupo bem sucedida!";
                        header("Location: ../perfil-usuario.php");
                        die();

                    }
                    else {
                        // Nome do grupo em branco
                        $_SESSION['danger'] = "Nome do grupo em branco! Favor preencher.";
                        header("Location: ../perfil-usuario.php");
                        die();
                    }
                    
                }
                else {
                    // Nome do grupo não setado
                    $_SESSION['danger'] = "Nome do grupo não setado!";
                    header("Location: ../perfil-usuario.php");
                    die();
                }

            }
            else {
                // Existem usernames em branco
                $_SESSION['danger'] = "Existem usuários em branco! Favor preencher.";
                header("Location: ../perfil-usuario.php");
                die();
            }
    
        }
        else {
            // Não existem usernames setados
            $_SESSION['danger'] = "Não existem usuários setados.";
            header("Location: ../perfil-usuario.php");
            die();
        }

    }
    else {
        // Não deu submit
        $_SESSION['danger'] = "Você não deu submit.";
        header("Location: ../perfil-usuario.php");
        die();
    }
