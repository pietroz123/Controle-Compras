<?php include("cabecalho.php"); ?>

<!-- Recebe as requisições de formulario-compra.php -->
<?php 

    $nome       = $_GET['nome'];
    $cidade     = $_GET['cidade'];
    $estado     = $_GET['estado'];
    $endereco   = $_GET['endereco'];
    $cep        = $_GET['cep'];
    $cpf        = $_GET['cpf'];
    $email      = $_GET['email'];
    $telefone   = $_GET['telefone'];

?>

<!-- Abre conexão e verifica possível erro -->
<?php 

    $conexao = mysqli_connect('localhost', 'root', '1234', 'my_controle_compras');
    $query = "insert into compradores (nome, cidade, estado, endereco, cep, cpf, email, telefone) values ('{$nome}', '{$cidade}', '{$estado}', '{$endereco}', '{$cep}', '{$cpf}', '{$email}', '{$telefone}');";

    if (mysqli_query($conexao, $query)) {
?>

<!-- insert into compradores (nome, cidade, estado, endereco, cep, cpf, email, telefone) values (); -->

        <!-- Alerta de sucesso -->
        <p class="alert-success">
            Comprador (<?= $nome; ?>, <?= $cidade; ?>, <?= $estado; ?>, <?= $endereco; ?>, <?= $cep; ?>, <?= $cpf; ?>, <?= $email; ?>, <?= $telefone; ?>) adicionado com sucesso!
        </p>

<!-- Else -->
<?php 
    } else {
?>

        <!-- Alerta de erro -->
        <p class="alert-danger">
            Erro na adição do comprador (<?= $nome; ?>, <?= $cidade; ?>, <?= $estado; ?>, <?= $endereco; ?>, <?= $cep; ?>, <?= $cpf; ?>, <?= $email; ?>, <?= $telefone; ?>)!
        </p>

<!-- Fecha a conexão -->
<?php
    }
    mysqli_close($conexao);
?>



<?php include("rodape.php"); ?>