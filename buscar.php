<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    
    verifica_usuario();
?>

<form action="resultado-busca.php">
    <div class="card">
        <div class="card-header">
            Buscar compras
        </div>
        <div class="card-body">
            <ul class="list-group">
                <div class="div-palavra-chave">
                    <li class="list-group-item">Palavra/frase chave</li>
                    <li class="list-group-item">
                        <input class="form-control palavra-chave" type="text" name="texto" placeholder="Digite a palavra chave">
                    </li>
                </div>
                <div class="div-data">
                    <li class="list-group-item">Data</li>
                    <li class="list-group-item">De: <input class="form-control" type="date" name="dataInicio" value="2018-01-01"></li>
                    <li class="list-group-item">Até: <input class="form-control" type="date" name="dataFim" value="<?= date('Y-m-d'); ?>"></li>
                </div>
                <div class="div-comprador">
                    <li class="list-group-item">Comprador</li>
                    <li class="list-group-item">
                        <select class="custom-select" name="comprador" id="comprador">
                            <option class="text-muted">Selecione uma Opção</option>
                            <option value="0" selected>Todos</option>
                            <?php 
                                $ids_compradores = recupera_ids_compradores_grupos($conexao, $_SESSION['login-username'], $_SESSION['login-email']);
                                foreach ($ids_compradores as $id_comprador) :
                                    $comprador = buscar_comprador($conexao, $id_comprador['Comprador_ID']);
                            ?>
                                    <option value="<?= $comprador['ID']; ?>"><?= $comprador['Nome']; ?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </li>
                </div>

            </ul><br>
                
            <button class="btn btn-success btn-block" type="submit" name="submit-buscar" value="true">Buscar</button>
        </div>
    </div>
</form>


<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>