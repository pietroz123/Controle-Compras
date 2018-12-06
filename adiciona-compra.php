<?php 
    include("cabecalho.php");
    include("conexao.php");
?>

<!-- Recebe as requisições de formulario-compra.php -->
<?php 

    $valor              = $_POST['valor'];
    $data               = $_POST['data'];
    $observacoes        = $_POST['observacoes'];
    $desconto           = $_POST['desconto'];
    $forma_pagamento    = $_POST['forma-pagamento'];
    $comprador_id       = $_POST['comprador-id'];

    $c = new Compra($valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id);

?>

<!-- Abre conexão e verifica possível erro -->
<?php 

    if ($op->adicionar_compra($mysqli, $c)) {   

?>

        <!-- Alerta de sucesso -->
        <p class="alert-success">
            Compra (<?= $valor; ?>, <?= $data; ?>, <?= $observacoes; ?>, <?= $desconto; ?>, <?= $forma_pagamento; ?>, <?= $comprador_id; ?>) adicionada com sucesso!
        </p>

<!-- Else -->
<?php 
    } else {
        $mensagem_erro = mysqli_error($mysqli);
?>

        <!-- Alerta de erro -->
        <p class="alert-danger">
            Erro na adição da compra (<?= $valor; ?>, <?= $data; ?>, <?= $observacoes; ?>, <?= $desconto; ?>, <?= $forma_pagamento; ?>, <?= $comprador_id; ?>)!<br>
            <?= $mensagem_erro; ?>
        </p>

<!-- Fecha a conexão -->
<?php
    }
?>



<?php include("rodape.php"); ?>