<?php
    include $_SERVER['DOCUMENT_ROOT'].'/compras/cabecalho.php';
?>

<?php
    mostra_alerta("danger");
?>

<?php
    $seletor = $_GET['seletor'];
    $token = $_GET['token'];

    if (empty($seletor) || empty($token)) {
        $_SESSION['danger'] = "Não foi possível validar sua requisição!";
        header("Location: ../index.php");
        die();
    } else {

        // Verifica se os tokens são válidos
        if (ctype_xdigit($seletor) !== false && ctype_xdigit($token) !== false) {
?>

            <form action="scripts/troca-senha.php" method="post">
                <input type="hidden" class="form-control" name="seletor" value="<?= $seletor ?>">
                <input type="hidden" class="form-control" name="token" value="<?= $token ?>">
                <input type="password" class="form-control" name="nova_senha" placeholder="Digite uma nova senha">
                <input type="password" class="form-control" name="nova_senha_rep" placeholder="Repita a senha">
                <button type="submit" class="btn btn-primary" name="submit-troca-senha">trocar a senha</button>
            </form>            

<?php
        }
    }
?>



<?php
    include $_SERVER['DOCUMENT_ROOT'].'/compras/rodape.php';
?>