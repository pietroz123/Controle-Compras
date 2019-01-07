<?php 
    include("cabecalho.php");
    include("conexao.php"); 
    include("funcoes.php");
    include("logica-usuarios.php");
?>

<?php
    verifica_usuario();
?>


<?php

    $id                 = $_POST['id'];
    $valor              = $_POST['valor'];
    $data               = $_POST['data'];
    $observacoes        = $_POST['observacoes'];
    $desconto           = $_POST['desconto'];
    $forma_pagamento    = $_POST['forma-pagamento'];
    $comprador_id       = $_POST['comprador-id'];
    
    if (alterar_compra($conexao, $id, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id)) {

?>

        <p class="alert-success">Compra (ID = '<?= $id ?>') alterada!</p><br>

<?php
    } else {
        $mensagem_erro = mysqli_error($conexao);
?>

        <p class="alert-danger">Erro na alteração da compra (ID = '<?= $id ?>')!</p><br>

<?php
    }
    mysqli_close($conexao);
?>



<?php include("rodape.php"); ?>