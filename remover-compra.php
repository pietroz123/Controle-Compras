<?php 
    include("cabecalho.php");
    include("conexao.php"); 
    include("funcoes.php");
?>


<?php

    $id = $_GET['id'];
    if (remover_compra($conexao, $id)) {

?>

        <p class="alert-success">Compra (ID = '<?= $id ?>') removida!</p><br>

<?php
    } else {
        $mensagem_erro = mysqli_error($conexao);
?>

        <p class="alert-danger">Erro na remoção da compra (ID = '<?= $id ?>')!</p><br>

<?php
    }
    mysqli_close($conexao);
?>



<?php include("rodape.php"); ?>