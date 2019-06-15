<?php

    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';

    date_default_timezone_set('America/Sao_Paulo');    

    // Inicia a sessao
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';


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
                        
                        if (!$stmt = $dbconn->prepare($sql)) {
                            $_SESSION['danger'] = "Ocorreu um erro na inserção do grupo.";
                            header("Location: ../perfil-usuario.php");
                            die();
                        
                        } else {
                            $stmt->bindParam(1, $nome_grupo);
                            $stmt->execute();
                            // Sucesso
                        }

                        // ======== INSERÇÃO DOS USUÁRIOS ========

                        /* Como o POST é um array com os IDs dos Usuários, precisamos buscar o username de cada um utilizando uma query */
                        /* Essa query é executada a partir da função buscar_usuarios_id() */
                        
                        
                        $id_grupo = $dbconn->lastInsertId();


                        // Insere o usuário logado no grupo como Admin do grupo e o autoriza
                        
                        $sql = "INSERT INTO grupo_usuarios (id_grupo, username, admin, autorizado, membro_desde, convidado_por) VALUES (?, ?, 1, 1, ?, ?)";
                        
                        if (!$stmt = $dbconn->prepare($sql)) {
                            $_SESSION['danger'] = "Ocorreu um erro na inserção do usuário logado no grupo.";
                            header("Location: ../perfil-usuario.php");
                            die();
                        
                        } else {
                            $stmt->bindParam(1, $id_grupo);
                            $stmt->bindParam(2, $_SESSION['login-username']);
                            $stmt->bindParam(3, date("Y-m-d H:i:s"));
                            $stmt->bindParam(4, $_SESSION['login-username']);
                            $stmt->execute();
                            // Sucesso
                        }


                        // Para cada usuário, inserimos no grupo

                        foreach ($ids_usuarios as $id_usuario) {
                            $usuario = buscar_usuario_id($dbconn, $id_usuario);

                            $sql = "INSERT INTO grupo_usuarios (id_grupo, username, convidado_por) VALUES (?, ?, ?)";
                            
                            if (!$stmt = $dbconn->prepare($sql)) {
                                $_SESSION['danger'] = "Ocorreu um erro na inserção dos usuários no grupo.";
                                header("Location: ../perfil-usuario.php");
                                die();
                            
                            } else {
                                $stmt->bindParam(1, $id_grupo);
                                $stmt->bindParam(2, $usuario['Usuario']);
                                $stmt->bindParam(3, $_SESSION['login-username']);
                                $stmt->execute();
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
