<?php
    if (isset($_POST['id_grupo'])) {

        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';        
        include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';

        $id_grupo = $_POST['id_grupo'];
        $grupo = recuperar_grupo($conexao, $id_grupo);
        $membros = recuperar_membros($conexao, $id_grupo);
?>

    <!-- <pre><?php //print_r($grupo); ?></pre> -->
    <!-- <pre><?php //print_r($membros); ?></pre> -->

    <div class="modal-content" id="usuarios-grupo">
        <div class="modal-header">
            <div class="grid informacoes-grupo" style="width: 100%;">
                <div class="row">
                    <div class="col"><h3 class="titulo-membros"><?= $grupo['Nome']; ?></h3></div>
                </div>
                <div class="row">
                    <div class="col-sm-6"><h6 id="data-criacao">Data de Criação:</h6></div>
                    <div class="col-sm-6"><h6 id="data"><?= $grupo['Data_Criacao']; ?></h6></div>
                </div>
                <div class="row">
                    <div class="col-sm-6"><h6 id="numero-membros">Número de Membros:</h6></div>
                    <div class="col-sm-6"><h6 id="numero"><?= $grupo['Numero_Membros']; ?></h6></div>
                </div>
            </div>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-hover">
                <thead>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Desde</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php 
                        foreach ($membros as $membro) {
                    ?>
                    <tr>
                        <td><i class="fas fa-user"></i></td>
                        <td><?= $membro['Nome']; ?></td>
                        <td><?= date("d/m/Y h:m", strtotime($membro['Membro_Desde'])); ?></td>
                        <td><button class="btn btn-white botao-pequeno btn-remover-membro" id-grupo="<?= $grupo['ID']; ?>" username-membro="<?= $membro['Usuario']; ?>"><img src="img/cancel.png" style="width: 23px; height: 23px;"></button></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <form action="scripts/remover-grupo.php" method="post">
                <input type="hidden" name="id" value="<?= $grupo['ID']; ?>">
                <button type="submit" name="submit-remover-grupo" class="btn btn-danger">remover grupo</button>
            </form>
        </div>
    </div>

<?php
    }