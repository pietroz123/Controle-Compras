<?php 
    include("cabecalho.php");
    include("conexao.php"); 
    // include("compra-class.php");
?>

<!-- Recebe as requisições de formulario-compra.php -->
<?php 

    $valor              = $_GET['valor'];
    $data               = $_GET['data'];
    $recebido           = $_GET['recebido'];
    $observacoes        = $_GET['observacoes'];
    $desconto           = $_GET['desconto'];
    $forma_pagamento    = $_GET['forma-pagamento'];
    $comprador_id       = $_GET['comprador-id'];

    $c = new Compra($valor, $data, $recebido, $observacoes, $desconto, $forma_pagamento, $comprador_id);

    $conn = new Conexao();
    $conn->open();
    $conn->adicionar_compra($c);

    // $op = new OperacoesBD();
    // $op->adicionar_compra($conn, $c);
    // die();

?>

<!-- Abre conexão e verifica possível erro -->
<?php 

    $query = "insert into compras (valor, data, recebido, observacoes, desconto, forma_pagamento, comprador_id) values ({$valor}, '{$data}', {$recebido}, '{$observacoes}', {$desconto}, '{$forma_pagamento}', {$comprador_id});";

    if (mysqli_query($conexao, $query)) {
?>

        <!-- Alerta de sucesso -->
        <p class="alert-success">
            Compra (<?= $valor; ?>, <?= $data; ?>, <?= $recebido; ?>, <?= $observacoes; ?>, <?= $desconto; ?>, <?= $forma_pagamento; ?>, <?= $comprador_id; ?>) adicionada com sucesso!
        </p>

<!-- Else -->
<?php 
    } else {
    $mensagem_erro = mysqli_error($conexao);
?>

        <!-- Alerta de erro -->
        <p class="alert-danger">
            Erro na adição da compra (<?= $valor; ?>, <?= $data; ?>, <?= $recebido; ?>, <?= $observacoes; ?>, <?= $desconto; ?>, <?= $forma_pagamento; ?>, <?= $comprador_id; ?>)!<br>
            <?= $mensagem_erro; ?>
        </p>

<!-- Fecha a conexão -->
<?php
    }
    mysqli_close($conexao);
?>



<?php include("rodape.php"); ?>