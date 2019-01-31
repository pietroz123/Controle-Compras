<?php
    if (isset($_POST['id_grupo'])) {


        include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';        
        include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
        include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';

        $id_grupo = $_POST['id_grupo'];


        // Verifica se a requisicao foi para remover um membro do grupo
        if (isset($_POST['remover']) && $_POST['remover'] == "sim") {

            $username = $_POST['username'];

            remover_membro($conexao, $id_grupo, $username);

        }


        // Verifica se a requisicao foi para adicionar um membro ao grupo
        if (isset($_POST['adicionar']) && $_POST['adicionar'] == "sim") {

            $ids_adicionar = $_POST['ids_adicionar'];
            foreach ($ids_adicionar as $id_adicionar) {
                $usuario = buscar_usuario_id($conexao, $id_adicionar);
                adicionar_membro($conexao, $id_grupo, $usuario['Usuario']);
            }

        }


        $grupo = recuperar_grupo($conexao, $id_grupo);
        $membros = recuperar_membros($conexao, $id_grupo);
?>

    <div class="modal-content">
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
                        <td><button class="btn btn-danger botao-pequeno btn-remover-membro" id-grupo="<?= $grupo['ID']; ?>" username-membro="<?= $membro['Usuario']; ?>" data-toggle="confirmation" data-singleton="true"><i class="fas fa-times"></i></button></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <hr>
            <div class="container mt-3 mb-3">
                <div class="row">
                    <div class="col-sm">
                        <label for="select2" class="font-weight-bold left">Adicionar usuários</label>
                        <select class="form-control input-usuario" id="select2-usuarios" name="usernames[]" multiple="multiple" style="width: 100%;">
                
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <button class="btn btn-success btn-block btn-adicionar-membros" id-grupo="<?= $grupo['ID']; ?>">adicionar</button>
                    </div>
                </div>
            </div>
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