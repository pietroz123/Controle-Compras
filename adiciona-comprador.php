<?php
    include $_SERVER['DOCUMENT_ROOT'].'/compras/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/compras/includes/funcoes.php';
?>

<?php
    verifica_usuario();
?>

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

    if (inserir_comprador($conexao, $nome, $cidade, $estado, $endereco, $cep, $cpf, $email, $telefone)) {

?>

<!-- insert into compradores (nome, cidade, estado, endereco, cep, cpf, email, telefone) values (); -->

        <!-- Alerta de sucesso -->
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="alert alert-success" role="alert">
                        <p class="alert-success">
                            Comprador (<?= $nome; ?>, <?= $cidade; ?>, <?= $estado; ?>, <?= $endereco; ?>, <?= $cep; ?>, <?= $cpf; ?>, <?= $email; ?>, <?= $telefone; ?>) adicionado com sucesso!
                        </p>
                        <hr>
                        <p class="mb-0">
                            <a href="formulario-comprador.php" class="alert-link">Inserir Outro Comprador</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

<!-- Else -->
<?php 
    } else {
        $mensagem_erro = mysqli_error($conexao);
?>

        <!-- Alerta de erro -->
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger">
                        <h2 class="alert-heading">Erro na Adição do Comprador</h2>
                        <p>
                            <?= $mensagem_erro; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

<!-- Fecha a conexão -->
<?php
    }
?>



<?php include $_SERVER['DOCUMENT_ROOT'].'/compras/rodape.php'; ?>