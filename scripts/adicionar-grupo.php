<?php

    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';


    // Inicia a sessao
    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }


    if (isset($_POST['submit-criar-grupo'])) {

        if (isset($_POST['usernames'])) {

            if (!empty($_POST['usernames'])) {

                if (isset($_POST['nome-grupo'])) {

                    if (!empty($_POST['nome-grupo'])) {

                        // Recupera as informações no $_POST
                        $nome_grupo = $_POST['nome-grupo'];
                        $ids_usuarios = $_POST['usernames'];

                        /* Podemos inserir o grupo */

                        // ======== INSERÇÃO DO GRUPO =========
                        
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

                        /* Como o POST é um array com os IDs dos Usuários, precisamos buscar o username de cada um utilizando uma query */
                        /* Essa query é executada a partir da função buscar_usuarios_id() */
                        
                        
                        $id_grupo = mysqli_stmt_insert_id($stmt);


                        // Insere o usuário logado no grupo
                        
                        $sql = "INSERT INTO grupo_usuarios (id_grupo, username, admin) VALUES (?, ?, 1)";
                        $stmt = mysqli_stmt_init($conexao);
                        
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            $_SESSION['danger'] = "Ocorreu um erro na inserção do usuário logado no grupo.";
                            header("Location: ../perfil-usuario.php");
                            die();
                        
                        } else {
                            mysqli_stmt_bind_param($stmt, "is", $id_grupo, $_SESSION['login-username']);
                            mysqli_stmt_execute($stmt);
                            // Sucesso
                        }


                        // Para cada usuário, inserimos no grupo

                        foreach ($ids_usuarios as $id_usuario) {
                            $usuario = buscar_usuario_id($conexao, $id_usuario);

                            $sql = "INSERT INTO grupo_usuarios (id_grupo, username) VALUES (?, ?)";
                            $stmt = mysqli_stmt_init($conexao);
                            
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                $_SESSION['danger'] = "Ocorreu um erro na inserção dos usuários no grupo.";
                                header("Location: ../perfil-usuario.php");
                                die();
                            
                            } else {
                                mysqli_stmt_bind_param($stmt, "is", $id_grupo, $usuario['Usuario']);
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
            $_SESSION['danger'] = "Você deve obrigatoriamente adicionar uma pessoa no grupo.";
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
