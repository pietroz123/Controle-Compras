<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
?>

<?php
    verifica_usuario();
    mostra_alerta("success");
    mostra_alerta("danger");

    $usuario = join_usuario_comprador($conexao, $_SESSION['login']);
?>

    <pre><?php print_r($usuario); ?></pre>


    <h2 class="titulo-perfil">Perfil de <?= $usuario['Nome']; ?></h2>

    <div class="grid dados-perfil">
        <div class="row">
            <div class="col col-md-5 mb-3">
                <div class="card z-depth-2">
                    <div class="card-header default-color white-text">Dados Pessoais</div>
                    <div class="card-body">
                        <h5 class="nome-perfil"><?= $usuario['Nome']; ?></h5>
                        <p class="texto-dados"><?= $usuario['Telefone']; ?></p>
                        <p class="texto-dados"><?= $usuario['CPF']; ?></p>
                        <p class="texto-dados"><?= $usuario['Email']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col col-md-7 mb-3">
                <div class="card z-depth-2">
                    <div class="card-header default-color white-text">Endereço</div>
                    <div class="card-body">
                        <h5 class="nome-perfil"><?= $usuario['Nome']; ?></h5>
                        <p class="texto-dados"><?= $usuario['Endereco']; ?></p>
                        <p class="texto-dados"><?php echo $usuario['Cidade'] . ' - ' . $usuario['Estado'] ?></p>
                        <p class="texto-dados"><?= $usuario['CEP']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card z-depth-2">
                    <div class="card-header default-color-dark white-text">
                        Grupos
                        <button class="btn default-color botao-pequeno ml-2 btn-recarregar" style="float: right;"><i class="fas fa-sync-alt" id="icone-recarregar"></i> recarregar grupos</button>
                        <button class="btn default-color botao-pequeno" style="float: right;" data-toggle="modal" data-target="#modal-criar-grupo">criar grupo</button>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <?php
                                $grupos = recuperar_grupos($conexao, $usuario['Usuario']);
                                if (count($grupos) > 0) {
                            ?>
                                <pre><?php print_r($grupos); ?></pre>
                                <pre><?php echo count($grupos); ?></pre>
                                <table class="table table-hover">
                                    <thead style="font-weight: bold;">
                                        <tr class="row">
                                            <th class="col-sm-4 thead-grupos">Nome</th>
                                            <th class="col-sm-3 thead-grupos">Data Criação</th>
                                            <th class="col-sm-3 thead-grupos">Número Membros</th>
                                            <th class="col-sm-2 thead-grupos">Visualizar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach ($grupos AS $grupo) {
                                    ?>
                                        <tr class="row">
                                            <td class="col-sm-4"><?= $grupo['Nome']; ?></td>
                                            <td class="col-sm-3"><?= $grupo['Data_Criacao']; ?></td>
                                            <td class="col-sm-3"><?= $grupo['Numero_Membros']; ?></td>
                                            <td class="col-sm-2">
                                                <button class="btn btn-info botao-pequeno btn-membros" id="<?= $grupo['ID']; ?>">Membros</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php
                                        }
                                    }
                                    else {
                                ?>
                                    <div class="alert alert-danger" role="alert">Você não está em nenhum grupo</div>
                                <?php
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para membros do Grupo -->
    <div class="modal" id="modal-membros-grupo">
        <div class="modal-dialog" id="membros-grupo">
            <!-- Preenchido com AJAX (JS) -->
        </div>
    </div>

    <?php
        include 'modal-criar-grupo.php';
    ?>

<?php
    include $_SERVER['DOCUMENT_ROOT'].'/rodape.php';
?>

<script>

    $(document).ready(function() {

        // Preenche o modal-membros-grupo utilizando AJAX
        $(".btn-membros").click(function() {
            var id_grupo = $(this).attr("id");

            $.ajax({
                url: "modal-membros-grupo.php",
                method: "post",
                data: {
                    id_grupo: id_grupo
                },
                success: function(data) {
                    $("#membros-grupo").html(data);
                    $("#modal-membros-grupo").modal("show");
                }
            });
        });

        $(".btn-recarregar").click(function() {
            var icone = document.querySelector("#icone-recarregar");
            
            icone.classList.add('fa-spin');

            setTimeout(function() {
                icone.classList.remove('fa-spin');
            }, 1000);
        });


        /* ===========================================================================================================
        ===================================== REALIZA BUSCA POR USERNAMES NO BD ======================================
        ========================================= UTILIZA O PLUGIN select2 ===========================================
        ============================================================================================================== */
        

        $('.input-usuario').select2({
            ajax: {
                url: "scripts/busca-usuario.php",
                type: "post",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        busca: "sim",
                        texto: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

    });

</script>