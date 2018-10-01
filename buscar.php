<?php 
    include("cabecalho.php");
    include("conexao.php");
?>

<form action="resultado-busca.php">
    <div class="card">
        <div class="card-header">
            Buscar compras
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <td>Palavra/frase chave</td>
                    <td><input class="form-control" type="text" name="texto"></td>
                </tr>
                <tr>
                    <td>Data</td>
                    <td>De: <input class="form-control" type="date" name="dataInicio"><br>Até: <input class="form-control" type="date" name="dataFim"></td>
                </tr>
            </table>
            <button class="btn btn-success btn-block" type="submit">Buscar</button>
        </div>
    </div><br><br>
</form>


<?php include("rodape.php"); ?>