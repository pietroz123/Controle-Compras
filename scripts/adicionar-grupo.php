<?php

    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';

    if (isset($_POST['submit-criar-grupo'])) {

        if (isset($_POST['usernames'])) {

            if (!empty($_POST['usernames'])) {

                if (isset($_POST['nome-grupo'])) {

                    if (!empty($_POST['nome-grupo'])) {

                        /* Podemos inserir o grupo */
                        foreach ($_POST['usernames'] as $username) {
                            echo '<p>' . $username . '</p>';
                        }

                        

                    }
                    else {
                        // Nome do grupo em branco
                    }
                    
                }
                else {
                    // Nome do grupo não setado
                }

            }
            else {
                // Existem usernames em branco
            }
    
        }
        else {
            // Não existem usernames setados
        }

    }
    else {
        // Não deu submit
    }
