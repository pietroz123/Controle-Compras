<?php
    if (isset($_POST['id_grupo'])) {


        include $_SERVER['DOCUMENT_ROOT'].'/database/dbconnection.php';
        include $_SERVER['DOCUMENT_ROOT'].'/config/sessao.php';        
        include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
        include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';

        $id_grupo = $_POST['id_grupo'];


        // Verifica se a requisicao foi para remover um membro do grupo
        if (isset($_POST['remover']) && $_POST['remover'] == "sim") {

            $username = $_POST['usuario'];

            remover_membro($dbconn, $id_grupo, $username);

        }

        // Verifica se a requisicao foi para adicionar um membro ao grupo
        elseif (isset($_POST['adicionar']) && $_POST['adicionar'] == "sim") {

            $ids_adicionar = $_POST['ids_adicionar'];
            foreach ($ids_adicionar as $id_adicionar) {
                $usuario = buscar_usuario_id($dbconn, $id_adicionar);
                adicionar_membro($dbconn, $id_grupo, $usuario['Usuario'], $_SESSION['login-username']);
            }

        }

        // Verifica se a requisicao foi para sair do grupo
        elseif (isset($_POST['sair']) && $_POST['sair'] == "sim") {

            $username = $_POST['usuario'];
            
            // =======================================================
            // Promove outro ADMIN
            // Critério: Membro mais antigo do grupo
            // =======================================================

            if (isAdmin($dbconn, $id_grupo, $username)) {
                if (promove_admin($dbconn, $id_grupo)) {
                    // Saiu do grupo com sucesso
                }
            }

            // Sai do grupo
            remover_membro($dbconn, $id_grupo, $username);

            $membros = recuperar_membros($dbconn, $id_grupo);
            $retorno['quantidade'] = count($membros);
            echo json_encode($retorno);
            die();            

        }


        $grupo = recuperar_grupo($dbconn, $id_grupo);
        $membros = recuperar_membros($dbconn, $id_grupo);
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
            <div class="container">
                <table class="table table-hover text-left">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Desde</th>
                            <th></th>
                        </tr>
                    </thead>

                    <!--
                    =======================================================
                    MEMBROS DO GRUPO
                    =======================================================
                    -->
                    
                    <tbody>
                    <?php
                        // Loop pelos membros do grupo
                        foreach ($membros as $membro) {
                    ?>
                        <tr>
                            <td>
                                <!-- Imagem do usuário, nome e indicação de admin (caso aplicável) -->
                                <img src="scripts/icone.php?icone=<?= $membro['Usuario']; ?>" class="smaller-icon mr-3"><?= $membro['Nome']; ?>
                            <?php

                                // Caso o usuário atual seja um admin, coloca um badge de ADMIN
                                if (isAdmin($dbconn, $grupo['ID'], $membro['Usuario'])) {
                                    echo '<span class="badge badge-pill badge-light float-right">ADMIN</span>';
                                }
                                ?>
                            </td>
                            <td>
                            <?php
                                // Caso o usuário atual não autorizou sua entrada ainda, coloca um badge de pendência
                                if ($membro['Autorizado'] == false) {
                                    echo '<span class="badge badge-pill badge-success">PENDENTE</span>';
                                }
                                else {
                                    echo date("d/m/Y H:i", strtotime($membro['Membro_Desde']));
                                }
                            ?>
                            </td>
                    <?php
                        // Caso o usuário logado seja o Admin do grupo, permite a remoção dos membros
                        if (isAdmin($dbconn, $grupo['ID'], $_POST['username']) && $membro['Usuario'] != $_POST['username']) {
                    ?>
                            <td class="text-right"><button class="btn-simples float-effect btn-remover-membro" id-grupo="<?= $grupo['ID']; ?>" username-usuario="<?= $_POST['username']; ?>" username-membro="<?= $membro['Usuario']; ?>" data-toggle="confirmation" data-singleton="true"><i class="fas fa-times"></i></button></td>
                    <?php
                        }
                    ?>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>

                </table>
            </div>
            
            <!--
            =======================================================
            ADIÇÃO DE NOVOS MEMBROS
            =======================================================
            -->

            <?php
                // Permite a adição de novos membros apenas caso o usuário logado seja o Admin do grupo
                if (isAdmin($dbconn, $grupo['ID'], $_POST['username'])) {
            ?>
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
                            <button class="botao rounded mb-0 p-2 text-uppercase btn-block btn-adicionar-membros" id-grupo="<?= $grupo['ID']; ?>" username-usuario="<?= $_POST['username']; ?>">adicionar</button>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>

        </div>
        <div class="modal-footer">
            <button class="btn red darken-4 btn-sair-grupo float-left" id-grupo="<?= $grupo['ID']; ?>" username-usuario="<?= $_POST['username']; ?>" data-toggle="confirmation" data-singleton="true">sair do grupo</button>
        </div>
    </div>

<?php
    }