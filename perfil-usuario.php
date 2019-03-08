<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
?>

<?php
    verifica_usuario();
    mostra_alerta("success");
    mostra_alerta("danger");

    $usuario = join_usuario_comprador($conexao, $_SESSION['login-email']);
?>


    <h2 class="titulo-perfil">Perfil de <?= $usuario['Nome']; ?></h2>

    <div class="grid dados-perfil">

        <div class="card z-depth-2">
            <div class="card-header default-color white-text">Dados Pessoais</div>
            <div class="card-body">
                
                <div class="container">

                    <form action="scripts/alterar-dados-perfil.php" method="post" id="form-perfil">

                        <!-- Dados gerais -->
                        <div class="row dados-gerais">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                                <div class="mb-3">
                                    <h6 class="titulo-dados">Dados gerais</h6>
                                    <hr>
                                    <a class="btn btn-light botao-pequeno mt-1 btn-editar" href="#!"><i class="fas fa-edit"></i> editar</a>
                                </div>
                                <div class="row">
                                    <div class="container imagem-perfil">
                                        <img src="img/user-icons/<?= $_SESSION['login-username']; ?>.png" style="height: 200px; width: 240px;" class="" alt="Imagem perfil">
                                    </div>
                                </div>
                            </div>
                            <div class="col dados">

                                <label for="nome-usuario" class="font-small font-weight-bold">Nome</label>
                                <input class="form-control" type="text" name="nome" id="nome-usuario" value="<?= $usuario['Nome']; ?>" disabled>

                                <label for="cpf-usuario" class="font-small font-weight-bold">CPF</label>
                                <input class="form-control" type="tel" name="cpf" id="cpf-usuario" value="<?= $usuario['CPF']; ?>" disabled editable>

                                <label for="email-usuario" class="font-small font-weight-bold">E-Mail</label>
                                <input class="form-control" type="email" name="email" id="email-usuario" value="<?= $usuario['Email']; ?>" disabled editable>

                                <label for="telefone-usuario" class="font-small font-weight-bold">Telefone</label>
                                <input class="form-control" type="tel" name="telefone" id="telefone-usuario" value="<?= $usuario['Telefone']; ?>" disabled editable>

                            </div>
                        </div>

                        <hr>

                        <!-- Dados endereço -->
                        <div class="row mt-4 dados-endereco">
                            <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                                <div class="mb-3">
                                    <h6 class="titulo-dados">Dados endereço</h6>
                                    <hr>
                                    <a class="btn btn-light botao-pequeno mt-1 btn-editar" href="#!"><i class="fas fa-edit"></i> editar</a>
                                </div>
                            </div>
                            <div class="col dados">

                                <label for="cep-usuario" class="font-small font-weight-bold">CEP</label>
                                <input class="form-control" type="tel" name="cep" id="cep-usuario" value="<?= $usuario['CEP']; ?>" disabled editable>

                                <label for="cidade-usuario" class="font-small font-weight-bold">Cidade</label>
                                <input class="form-control" type="text" name="cidade" id="cidade-usuario" value="<?= $usuario['Cidade']; ?>" disabled editable>

                                <label for="estado-usuario" class="font-small font-weight-bold">Estado</label>
                                <input class="form-control" type="text" name="estado" id="estado-usuario" value="<?= $usuario['Estado']; ?>" disabled editable>

                                <label for="endereco-usuario" class="font-small font-weight-bold">Endereço</label>
                                <input class="form-control" type="text" name="endereco" id="endereco-usuario" value="<?= $usuario['Endereco']; ?>" disabled editable>

                            </div>
                        </div>

                    </form>


                </div>
                
            </div>
        </div>

        <div class="card z-depth-2 mt-3" id="cartao-grupos-usuario">
            
            <div class="card-header default-color-dark white-text d-flex justify-content-around flex-sm-row flex-column">
                
                <div class="mr-auto">Grupos</div>
                <div class="float-right">
                    <button class="btn default-color botao-pequeno btn-criar-grupo float-right btn-block mr-2" data-toggle="modal" data-target="#modal-criar-grupo" data-username="<?= $usuario['Usuario']; ?>">criar grupo</button>
                    <div class="adicional" style="display: none; float: left;"></div>
                </div>
                <div class="float-right"><button class="btn default-color botao-pequeno btn-recarregar-grupos btn-block" username-usuario="<?= $usuario['Usuario'] ?>"><i class="fas fa-sync-alt" id="icone-recarregar"></i> recarregar grupos</button></div>
            
            </div>

            <div class="card-body">
                <div class="container" id="container-tabela-grupos">
                    <?php
                        $grupos = recuperar_grupos($conexao, $usuario['Usuario']);
                        if (count($grupos) > 0) {
                    ?>
                        <table class="table table-hover table-grupos" id="tabela-grupos">
                            <thead style="font-weight: bold;">
                                <tr>
                                    <th class="thead-grupos">Nome</th>
                                    <th class="thead-grupos">Data Criação</th>
                                    <th class="thead-grupos">Número Membros</th>
                                    <th class="thead-grupos">Visualizar</th>
                                </tr>
                            </thead>
                            <tbody id="grupos-usuario">

                            <?php foreach ($grupos AS $grupo) { ?>
                                <tr>
                                    <td><?= $grupo['Nome']; ?></td>
                                    <td><?= date("d/m/Y h:m", strtotime($grupo['Data_Criacao'])); ?></td>
                                    <td><?= $grupo['Numero_Membros']; ?></td>
                                    <td>
                                        <button class="btn btn-info botao-pequeno btn-membros" id="<?= $grupo['ID']; ?>" username="<?= $usuario['Usuario']; ?>">Membros</button>
                                    </td>
                                </tr>
                            <?php } ?>

                            </tbody>
                    <?php
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

        var url = window.location.href;
        var id = url.substring(url.lastIndexOf("#") + 1);
        

        // =======================================================
        // Script para adicionar a flecha de criar novo grupo
        // =======================================================
        if (id == "cartao-grupos-usuario") {

            // Scroll até a tabela de compras
            $('html, body').animate({
                scrollTop: $("#" + id).offset().top - 120
            }, 1500);

            // Cria um efeito
            $(".btn-criar-grupo").effect( "shake", "slow" );

            // Recupera a largura do botão para centralizar a flecha
            var largura = $(".btn-criar-grupo").width();

            // Adiciona o display
            $(".adicional").css({
                'display': 'inline'
            });

            // Adiciona a flecha pra baixo
            $(".adicional").html('<div class="arrow bounce"><a class="fa fa-arrow-down fa-3x text-black-75" href="#"></a></div>');
            
            // Adiciona o CSS para centralizar e colocar no topo
            $(".arrow").css({
                'position': 'absolute',
                'z-index': '1',
                'margin-left': ((largura/2) - 10) + "px",
                'top': '-50px'
            });


        }


        // =======================================================
        // Design responsivo botões criar e recarregar
        // =======================================================
        $(window).resize(function() {
            if ($(window).width() <= 576) {
                $('.btn-criar-grupo').removeClass("mr-2");
                $('.btn-criar-grupo').addClass("mt-2");
                $('.btn-recarregar-grupos').addClass("mt-2");
            } else {
                $('.btn-criar-grupo').addClass("mr-2");
                $('.btn-criar-grupo').removeClass("mt-2");
                $('.btn-recarregar-grupos').removeClass("mt-2");
            }
        });


        $('#modal-criar-grupo').on('show.bs.modal', function(event) {
            // Recupera as informacoes do botao
            var botao = $(event.relatedTarget);
            var username = botao.data('username');

            var modal = $(this);
            modal.find('#criar-username').val(username);
        });


        // =======================================================
        // Máscaras
        // =======================================================

        $("#cpf-usuario").mask('000.000.000-00');             /* Formata o CPF */
        $("#cep-usuario").mask('00000-000');                  /* Formata o CEP */
        $('#telefone-usuario').mask('(00) 00000-0000');       /* Formata o telefone */


        // =======================================================
        // Preenchimento automatico do endereco via CEP
        // =======================================================

        // Via JSON:
        // {
        //     "cep": "01001-000",
        //     "logradouro": "Praça da Sé",
        //     "complemento": "lado ímpar",
        //     "bairro": "Sé",
        //     "localidade": "São Paulo",
        //     "uf": "SP",
        //     "unidade": "",
        //     "ibge": "3550308",
        //     "gia": "1004"
        // }

        // Implementação do delay para o keyup
        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                callback.apply(context, args);
                }, ms || 0);
            };
        }

        function limpa_formulario_cep() {
            // Limpa valores do formulário de cep.
            $('#cidade-usuario').val('');
            $('#estado-usuario').val('');
            $('#endereco-usuario').val('');
        }

        $('#cep-usuario').keyup(delay(function() {            

            // Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            // Verifica se o CEP não é vazio
            if (cep != "") {

                // Loading enquanto procura o CEP
                $('#cidade-usuario').val('...');
                $('#estado-usuario').val('...');
                $('#endereco-usuario').val('...');

                setTimeout(function() {
                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#endereco-usuario").val(dados.logradouro);
                            $("#cidade-usuario").val(dados.localidade);
                            $("#estado-usuario").val(dados.uf);
                        }
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulario_cep();
                            alert("CEP não encontrado.");
                        }

                    });
                }, 1500);

            }

        }, 2000));



                
    });


    // =======================================================
    // Edição do perfil do usuário
    // =======================================================

    $(document).on('click', '.btn-editar', function() {

        // Deixa todos os campos disponiveis para edição
        var dados = $(this).parent().parent().parent().children('.dados');
        $(dados).children('input[editable]').each(function() {
            $(this).removeAttr('disabled');
        });

        // Modifica o ícone de editar para cancelar
        $(this).removeClass('btn-light btn-editar');
        $(this).addClass('btn-danger btn-cancelar');
        $(this).html('<i class="fas fa-times"></i> cancelar');

        // Adiciona botao de editar imagem de perfil, caso sejam dados gerais
        if (dados.parent().hasClass('dados-gerais')) {
            $('.imagem-perfil').append('<div class="texto-imagem"><a class="btn btn-editar-imagem botao-pequeno"><i class="far fa-edit"></i> Editar</a></div>');
        }
        
        // Adiciona botão de alteração ao form
        if( !($('.alterar').length) ) {
            $('#form-perfil').append('<div class="alterar"><hr><div class="row"><div class="col"><button class="btn btn-success float-right" type="submit" name="submit-alteracoes">realizar alterações</button></div></div></div>');
        }
        

    });

    $(document).on('click', '.btn-cancelar', function() {

        // Deixa todos os campos indisponiveis para edição
        var dados = $(this).parent().parent().parent().children('.dados');
        $(dados).children('input[editable]').each(function() {
            this.setAttribute('disabled', '');
        });

        // Modifica o ícone de cancelar para editar
        $(this).removeClass('btn-danger btn-cancelar');
        $(this).addClass('btn-light btn-editar');
        $(this).html('<i class="fas fa-edit"></i> editar');

        // Remove botao de editar imagem de perfil, caso sejam dados gerais
        if (dados.parent().hasClass('dados-gerais')) {
            $('.texto-imagem').remove();
        }

        // Se existe apenas um botao de edição, então remova a div com o botão de alteração
        if ( $('.btn-cancelar').length == 0 ) {
            $('.alterar').remove();
        }
        

    });

    

    /* ===========================================================================================================
    ===================================== PREENCHE MODAL MEMBROS GRUPO COM AJAX ==================================
    ============================================================================================================== */

    $(document).on('click', '.btn-membros', function() {
        var id_grupo = $(this).attr("id");
        var username = $(this).attr("username");            

        $.ajax({
            url: "modal-membros-grupo.php",
            method: "post",
            data: {
                id_grupo: id_grupo,
                username: username
            },
            success: function(data) {
                $("#membros-grupo").html(data);
                $("#modal-membros-grupo").modal("show");
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
            }
        });
    });


    /* ===========================================================================================================
    ========================================= RECARREGA OS GRUPOS COM AJAX =======================================
    ============================================================================================================== */

    $(".btn-recarregar-grupos").click(function() {
        var icone = document.querySelector("#icone-recarregar");
        var username = $(this).attr('username-usuario');
        
        icone.classList.add('fa-spin');

        setTimeout(function() {
            icone.classList.remove('fa-spin');
        }, 1000);

        $.ajax({
            url: "scripts/recarregar-grupos.php",
            method: "post",
            data: {
                username: username
            },
            success: function(retorno) {
                $('#container-tabela-grupos').html(retorno);                    
            }
        });

    });


    /* ===========================================================================================================
    ===================================== REALIZA BUSCA POR USERNAMES NO BD ======================================
    ========================================= UTILIZA O PLUGIN select2 ===========================================
    ============================================================================================================== */
    
    function formatarUsuario (usuario) {
        if (!usuario.id) {
            return usuario.text;
        }
        var baseUrl = "/img/user-icons";        
        var $usuario = $(
            '<span><img src="' + baseUrl + '/' + usuario.text + '.png" class="img-usuario" style="height: 30px; width: 30px;"> ' + usuario.text + '</span>'
        );
        return $usuario;
    };

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
        },
        templateResult: formatarUsuario
    });


    /* ===========================================================================================================
    ===================================== REALIZA REMOÇÃO DE UM MEMBRO NO GRUPO ==================================
    ============================================= E RECARREGA O MODAL ============================================
    ============================================================================================================== */
    
    $(document).on('mouseover', '.btn-remover-membro', function(){
        
        var id_grupo = $(this).attr("id-grupo");
        var username_usuario = $(this).attr('username-usuario');
        var usuario = $(this).attr("username-membro");

        
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function() {
                // Caso o usuário pressione 'Sim'
                $.ajax({
                    url: "modal-membros-grupo.php",
                    method: "post",
                    data: {
                        remover: "sim",
                        id_grupo: id_grupo,
                        usuario: usuario,
                        username: username_usuario
                    },
                    dataType: "html",
                    success: function(retorno) {
                        
                        $('#membros-grupo').html(retorno);
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
                    }
                });
            },
            onCancel: function() {
                // Caso o usuário pressione 'Não'
            }
            // other options
        });


    });


    /* ===========================================================================================================
    ====================================== REALIZA ADIÇÃO MAIS MEMBROS NO GRUPO ==================================
    ============================================= E RECARREGA O MODAL ============================================
    ============================================================================================================== */

    $(document).on('click', '.btn-adicionar-membros', function() {

        // Recupera os IDs dos usuários a serem adicionados
        var select = $('#select2-usuarios').val();
        var id_grupo = $(this).attr('id-grupo');        
        var username = $(this).attr('username-usuario');

        if (select) {
            $.ajax({
                url: "modal-membros-grupo.php",
                method: "post",
                data: {
                    adicionar: "sim",
                    id_grupo: id_grupo,
                    ids_adicionar: select,
                    username: username
                },
                dataType: "html",
                success: function(retorno) {
                    $('#membros-grupo').html(retorno);
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
                }
            });
        }
        
        
    });


    /* ===========================================================================================================
    ========================================== BOTÃO PARA SAIR DO GRUPO ==========================================
    ============================================================================================================== */

    $(document).on('click', '.btn-sair-grupo', function() {

        var id_grupo = $(this).attr('id-grupo');        
        var username = $(this).attr('username-usuario');

        $.ajax({
            url: "modal-membros-grupo.php",
            method: "post",
            dataType: "json",
            data: {
                sair: "sim",
                id_grupo: id_grupo,
                usuario: username
            },
            success: function(retorno) { 
                if (retorno.quantidade == 0) {
                    $.post('scripts/remover-grupo.php', {
                        remover_grupo: "sim",
                        id: id_grupo
                    }, function(data, status) {
                        location.href = "perfil-usuario.php";
                    });
                }
                else {
                    location.href = "perfil-usuario.php";
                }
            }
        });

    });



</script>