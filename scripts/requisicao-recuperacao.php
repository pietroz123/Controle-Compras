<?php
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';

    // Inicia a sessao
    include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';
    
    // Verifica se o botão de submit foi pressionado
    if (!isset($_POST['submit-recuperacao'])) {
        $_SESSION['danger'] = "Você não deu submit!";
        header("Location: ../index.php");
    }
    else {

        // Configuracoes do servidor
        $config         = parse_ini_file('../../private/config_compras.ini');
        $site           = $config['site'];
        $email_servidor = $config['email_servidor'];


        // Seletor e token para seguranca
        $seletor = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        // Url que o usuario devera acessar para criar uma nova senha
        $url = $site . "/criar-nova-senha.php?seletor=" . $seletor . "&token=" . bin2hex($token);

        // Tempo de expiracao de uma hora
        $expira = date("U") + 1800;


        // Recebe o e-mail enviado pelo formulario
        $email_usuario = $_POST['email'];


        // Deleta todos os possiveis tokens ainda existentes e relacionados ao e-mail do usuario
        $sql = "DELETE FROM recuperacao_senha WHERE email = ?;";
        if (!$stmt = $dbconn->prepare($sql)) {
            $_SESSION['danger'] = "Ocorreu um erro ao deletar os tokens pre-existentes.";
            header("Location: ../recuperacao-senha.php");
            die();
        } else {
            $stmt->bindParam(1, $email_usuario);
            $stmt->execute();
        }


        // Insere o novo token no banco de dados
        $sql = "INSERT INTO recuperacao_senha (email, seletor, token, expira) VALUES (?, ?, ?, ?);";
        if (!$stmt = $dbconn->prepare($sql)) {
            $_SESSION['danger'] = "Ocorreu um erro na inserção da requisição da senha.";
            header("Location: ../recuperacao-senha.php");
            die();
        } else {
            $hash_token = password_hash($token, PASSWORD_DEFAULT);
            $stmt->bindParam(1, $email_usuario);
            $stmt->bindParam(2, $seletor);
            $stmt->bindParam(3, $hash_token);
            $stmt->bindParam(4, $expira);
            $stmt->execute();
        }


        // Seleciona o usuario para exibir informações no email
        $sql = "SELECT * FROM compradores WHERE email = ?;";
        if (!$stmt = $dbconn->prepare($sql)) {
            $_SESSION['danger'] = "Ocorreu um erro ao buscar as informações do usuário.";
            header("Location: ../recuperacao-senha.php");
            die();
        } else {
            $stmt->bindParam(1, $email_usuario);
            $stmt->execute();

            $usuario = $stmt->fetch();
            if ($usuario == null) {
                $_SESSION['danger'] = "Usuário inexistente.";
                header("Location: ../recuperacao-senha.php");
                die();
            }
        }


        // Envia o e-mail
        $para = $email_usuario;
        $assunto = "Recupere sua senha para o Controle de Compras";
        
        $mensagem = "

            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset='utf-8' />
                    <meta name='viewport' content='width=device-width, initial-scale=1'>
                    <style>
                        .container {
                            margin-top: 50px;
                            width: 100%;
                            padding-right: 15px;
                            padding-left: 15px;
                            margin-right: auto;
                            margin-left: auto;
                        }
                        @media (min-width: 576px) {
                            .container {
                                max-width: 540px;
                            }
                        }
                        @media (min-width: 768px) {
                            .container {
                                max-width: 720px;
                            }
                        }
                        @media (min-width: 992px) {
                            .container {
                                max-width: 960px;
                            }
                        }
                        @media (min-width: 1200px) {
                            .container {
                                max-width: 1140px;
                            }
                        }
                        body {
                            background-color: #f2f2f2;
                        }
                        h1 {
                            letter-spacing: 1.2px;
                            border-bottom: 3px solid #990000;
                        }
                        .texto-email {
                            margin-top: 40px;
                            text-align: justify;
                            font-size: 17px;
                        }
                        .texto-email p {
                            margin-bottom: 15px;
                        }
                        footer {
                            position: fixed;
                            left: 0;
                            bottom: 0;
                            width: 100%;
                        }
                        footer p {
                            font-size: 18px;
                            background-color: #990000;
                            padding: 25px;
                            margin: 0;
                            color: white;
                            border: 3px solid black;
                        }
            
                        @media only screen and (max-width: 550px) {
                            h1 {
                                font-size: 18px;
                                width: 98.5%;   
                            }
                            .texto-email {
                                font-size: 14px;
                            }
                            footer p {
                                font-size: 16px;
                            }
                        }
                    </style>
                </head>
                <body>
            
                    <div class='container'>
                        <h1>Informações para a recuperação da sua senha</h1>
                        <div class='texto-email'>
                            <p style='margin-bottom: 15px;'>Olá " . explode(' ', $usuario['Nome'])[0] . ", tudo bem?</p>
                            <p>Recebemos uma requisição de recuperação de senha. O link para recuperar sua senha está logo abaixo. Se você não fez essa requisição, ignore este e-mail.</p>
                            <p style='margin-bottom: 50px;'>Aqui está o link de recuperação da senha:<br><a href='" . $url ."'>" . $url ."</a></p>
                            <p style='font-style: italic;'>A equipe do Controle de Compras agradece o seu contato.</p>
                        </div>
                    </div>
                </body>
            </html>
        
        ";

        $headers = "From: Pietro <" . $email_servidor . "\r\n";
        $headers .= "Reply-To: " . $email_servidor . "\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($para, $assunto, $mensagem, $headers);


        // Retorna para a pagina inicial
        $_SESSION['success'] = "Um e-mail foi enviado para '" . $email_usuario . "' com as informações de recuperação de senha. Verifique seu e-mail.";
        header("Location: ../recuperacao-senha.php");

    }