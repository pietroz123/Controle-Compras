<?php 
    include("cabecalho.php");
    include("database/conexao.php");
    include("funcoes.php");
?>

<?php
    verifica_usuario();
?>

<!-- Recebe as requisições de formulario-compra.php -->
<?php 

    $valor              = $_POST['valor'];
    $data               = $_POST['data'];
    $observacoes        = $_POST['observacoes'];
    $desconto           = $_POST['desconto'];
    $forma_pagamento    = $_POST['forma-pagamento'];
    $comprador_id       = $_POST['comprador-id'];


?>

<!-- Abre conexão e verifica possível erro -->
<?php 

    if (inserir_compra($conexao, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id)) {   

?>

        <!-- Alerta de sucesso -->
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="alert alert-success" role="alert">
                        <p>
                            Compra (<?= $valor; ?>, <?= $data; ?>, <?= $observacoes; ?>, <?= $desconto; ?>, <?= $forma_pagamento; ?>, <?= $comprador_id; ?>) adicionada com sucesso!
                        </p>
                        <hr>
                        <p class="mb-0">
                            <a href="formulario-compra-grid.php" class="alert-link">Inserir Outra Compra</a>
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
                        <h2 class="alert-heading">Erro na adição da Compra</h2>
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



<?php include("rodape.php"); ?>