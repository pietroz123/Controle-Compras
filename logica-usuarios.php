<?php

if (!isset($_SESSION) || !is_array($_SESSION)) {
    session_start();
}

// Mostra um alerta ao usuario, tanto de sucesso quanto de fracasso
function mostra_alerta($tipo) {
    if (isset($_SESSION[$tipo])) {
?>
        <div class="alert alert-<?= $tipo ?>" role="alert">
            <?= $_SESSION[$tipo] ?>
        </div>
<?php
    unset($_SESSION[$tipo]);
    }
}

// Verifica se o usuario esta logado e, caso contrario, o redireciona para a pagina principal
function verifica_usuario() {
    if (!usuario_esta_logado()) {
        $_SESSION['danger'] = "Voce nao tem acesso a essa funcionalidade.";
        header("Location: index.php");
        die();
    }
}

// Verifica se o usuario esta logado
function usuario_esta_logado() {
    return isset($_SESSION['login']);
}

// Retorna o usuario logado (seu id unico na sessao)
function usuario_logado() {
    return $_SESSION['login'];
}

// Efetua o login do usuario
function login($email_usuario) {
    $_SESSION['login'] = $email_usuario;
}