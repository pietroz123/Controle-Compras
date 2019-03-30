<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
    
    verifica_usuario();
?>

<form action="resultado-busca.php">
    <div class="card mt-5" id="cartao-busca">
        <div class="card-body p-2">
            
            <div class="card-header elegant-color-dark py-4 white-text text-uppercase">
                <div class="card-title" id="titulo-informacoes">Buscar</div>
            </div>

            <div class="elegant-color p-4 text-left" id="busca">

                <!-- Realizar Backup -->
                <div class="container white-text">
                    <div class="row">
                        <div class="col"><h4 class="white-text text-left py-2">Palavra/frase chave</h4></div>
                        <div class="col-12"><input class="form-control palavra-chave" type="text" name="texto" placeholder="Digite a palavra chave"></div>
                    </div>
                    <hr class="white">
                    <div class="row">
                        <div class="col"><h4 class="white-text text-left py-2">Data</h4></div>
                    </div>
                    <div class="row">
                        <div class="col"><h5 class="white-text text-left py-2">De:</h5></div>
                        <div class="col-12"><input class="form-control" type="date" name="dataInicio" value="<?= date('Y-m').'-01' ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col"><h5 class="white-text text-left py-2">Até:</h5></div>
                        <div class="col-12"><input class="form-control" type="date" name="dataFim" value="<?= date('Y-m-d'); ?>"></div>
                    </div>
                    <hr class="white">
                    <div class="row">
                        <div class="col"><h4 class="white-text text-left py-2">Comprador</h4></div>
                        <div class="col-12">
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
                        </div>
                    </div>
                </div>

                <hr class="white">
                    
                <button class="btn btn-default" type="submit" name="submit-buscar" value="true">realizar busca</button>
                    
                
            </div>

        </div>
    </div>
</form>


<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>