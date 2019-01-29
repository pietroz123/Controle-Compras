<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
?>

<?php
    verifica_usuario();
    mostra_alerta("success");
    mostra_alerta("danger");

    $usuario = join_usuario_comprador($conexao, $_SESSION['login']);
?>



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
                            <table class="table table-hover">
                                <thead>
                                    <tr class="row">
                                        <th class="col-sm-4">Nome</th>
                                        <th class="col-sm-3">Data Criação</th>
                                        <th class="col-sm-3">Número Membros</th>
                                        <th class="col-sm-2">Visualizar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="row">
                                        <td class="col-sm-4">Família</td>
                                        <td class="col-sm-3">2019-20-01</td>
                                        <td class="col-sm-3">2</td>
                                        <td class="col-sm-2">
                                            <button class="btn btn-info botao-pequeno btn-membros" id="1">Membros</button>
                                        </td>
                                    </tr>
                                    <tr class="row">
                                        <td class="col-sm-4">Amigos</td>
                                        <td class="col-sm-3">2019-24-01</td>
                                        <td class="col-sm-3">4</td>
                                        <td class="col-sm-2">
                                            <button class="btn btn-info botao-pequeno">Membros</button>
                                        </td>
                                    </tr>
                                </tbody>
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
        ===================================== ADICIONA E REMOVE CAMPOS DINÂMICOS =====================================
        ============================================================================================================== */

        var cont = 1;

        // Para adicionar os campos
        $("#adicionar").click(function() {
            cont++;
            $("#campos-dinamicos").append('<tr id="tr-usuario'+cont+'" class="dinamico-adicionado"><td><input id="usuario'+cont+'" type="text" name="usernames[]" placeholder="Digite um nome de usuário" class="form-control input-usuario" required></td><td><button type="button" name="remover" id="'+cont+'" class="btn btn-danger botao-pequeno btn-remover" style="padding: 9px;">remover</button></td></tr>');
        });

        // Para remover os campos
        $(document).on('click', '.btn-remover', function(){
            var id_botao = $(this).attr("id");
            $('#tr-usuario'+id_botao).remove();
        });

        /* ===========================================================================================================
        ===================================== REALIZA BUSCA POR USERNAMES NO BD ======================================
        ============================================================================================================== */

        var contUsuario = 1;

        // var awesomplete = new Awesomplete("#usuario"+contUsuario, {
        //     minChars: 1,
        //     autoFirst: true
        // });

        // Awesomplete detecta as setas para cima e para baixo como input, ou seja, recarrega o ajax. Assim, precisamos removê-las
        // Setas permitidas: de A a Z (65 a 90)
        var teclasLetras = [];
        for (let i = 65, j = 0; i <= 90; i++, j++) {
            teclasLetras[j] = i;
        }

        $(document).on('focus', '.input-usuario', function() {
            var id = $(this).attr("id");
            console.log(id);
            var awesomplete = new Awesomplete("#"+id, {
                minChars: 1,
                autoFirst: true
            });
            $("#"+id).on("keyup", function(e) {
                var usuario = $(this).val();
                // Verifica se não foram tecladas setas não permitidas
                if ($.inArray(e.keyCode, teclasLetras) !== -1) {
                    $.ajax({
                        url: "scripts/busca-usuario.php",
                        type: "post",
                        data: {
                            busca: "sim",
                            texto: usuario
                        },
                        dataType: "json",
                        success: function(retorno) {
                            if (retorno.quantidade > 0) {
                                var lista = [];
                                
                                $.each(retorno.dados, function(key, value) {                        
                                    lista.push(value);
                                });
                                
                                awesomplete.list = lista;
                            }
                        }
                    });
                }
            });
        });

        // $("#usuario"+contUsuario).on("keyup", function(e) {
        //     var usuario = $(this).val();
        //     // Verifica se não foram tecladas setas não permitidas
        //     if ($.inArray(e.keyCode, teclasLetras) !== -1) {
        //         $.ajax({
        //             url: "scripts/busca-usuario.php",
        //             type: "post",
        //             data: {
        //                 busca: "sim",
        //                 texto: usuario
        //             },
        //             dataType: "json",
        //             success: function(retorno) {
        //                 if (retorno.quantidade > 0) {
        //                     var lista = [];
                            
        //                     $.each(retorno.dados, function(key, value) {                        
        //                         lista.push(value);
        //                     });
                            
        //                     awesomplete.list = lista;
        //                 }
        //             }
        //         });
        //     }
        // });


    });

</script>