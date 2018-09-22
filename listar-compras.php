<?php 
    include("cabecalho.php");
    include("conexao.php"); 
?>

<?php 

    function listaCompras($conexao) {
        $compras = array();
        $resultado = mysqli_query($conexao, "select * from compras");
        while ($compra = mysqli_fetch_assoc($resultado)) {
            array_push($compras, $compra);
        }
        return $compras;
    }

?>

<table class="table">

    <?php
        $compras = listaCompras($conexao);
        foreach ($compras as $compra) :
    ?>

        <tr>
            <td><?= $compra['Observacoes']; ?></td>
        </tr>

    <?php
        endforeach
    ?>

</table>

<!-- 
Obs: O comando a seguir lista todas as características de cada compra no formato de um array
    echo "<pre>";
    echo print_r($produto); 
    echo "</pre>"; 
-->

<?php include("rodape.php"); ?>