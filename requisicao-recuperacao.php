<?php
    include("database/conexao.php");
?>

<?php

    if (!isset($_SESSION) || !is_array($_SESSION)) {
        session_start();
    }

    // Verifica se o botão de submit foi pressionado
    if (!isset($_POST['submit-recuperacao'])) {
        $_SESSION['danger'] = "Você não deu submit!";
        header("Location: index.php");
    }
    else {

        $seletor = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        $url = "www.pietroz.tech/criar-nova-senha.php?seletor=" . $seletor . "&token=" . bin2hex($token);

        $expira = date("U") + 1800;     // Uma hora para expirar

        // Recebe o e-mail enviado pelo formulario
        $email_usuario = $_POST['email'];

        // Deleta todos os possiveis tokens ainda existentes e relacionados ao e-mail do usuario
        $query = "DELETE FROM recuperacao_senha WHERE email = ?;";
        $stmt = mysqli_stmt_init($conexao);
        if (!mysqli_stmt_prepare($stmt, $query)) {
            $_SESSION['danger'] = "Ocorreu um erro na ao deletar os tokens pre-existentes.";
            header("Location: recuperacao-senha.php");
            die();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email_usuario);
            mysqli_stmt_execute($stmt);
        }

        // Insere o novo token no banco de dados
        $query = "INSERT INTO recuperacao_senha (email, seletor, token, expira) VALUES (?, ?, ?, ?);";
        if (!mysqli_stmt_prepare($stmt, $query)) {
            $_SESSION['danger'] = "Ocorreu um erro na inserção da requisição da senha.";
            header("Location: recuperacao-senha.php");
            die();
        } else {
            $hash_token = password_hash($token, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss", $email_usuario, $seletor, $hash_token, $expira);
            mysqli_stmt_execute($stmt);
        }
        
        mysqli_stmt_close($stmt);

        // Envia o e-mail
        $para = $email_usuario;
        $assunto = "Recupere sua senha para a Loja do Pietro";
        $mensagem = "<p>Nós recebemos uma requisição de recuperação de senha. O link para recuperar sua senha está logo abaixo. Se você não fez essa requisição, ignore este e-email.</p>";
        $mensagem .= "<p>Aqui está o link de recuperação da senha:<br>";
        $mensagem .= "<a href=" . $url . ">" . $url . "</a></p>";

        $headers = "From: Pietro <pietrozuntini@gmail.com>\r\n";
        $headers .= "Reply-To: Pietro pietrozuntini@gmail.com\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($para, $assunto, $mensagem, $headers);


        // Retorna para a pagina inicial
        $_SESSION['success'] = "Um e-mail foi enviado para '" . $email_usuario . "' com as informações de recuperação de senha. Verifique seu e-mail.";
        header("Location: recuperacao-senha.php");

    }