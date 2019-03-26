<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
?>

<?php
    verifica_usuario();
    mostra_alertas();

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
                                        <img src="scripts/icone.php?icone=<?= $_SESSION['login-username']; ?>" style="height: 200px; width: 240px;" class="" alt="Imagem perfil">
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
                                    <td class="nome-grupo"><?= $grupo['Nome']; ?></td>
                                    <td class="data-criacao-grupo"><?= date("d/m/Y H:i", strtotime($grupo['Data_Criacao'])); ?></td>
                                    <td class="numero-membros-grupo"><?= $grupo['Numero_Membros']; ?></td>
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

        <!-- Requisições só são acessíveis a nível do administrador -->
        <?php
            if (admin()) {
        ?>
        <div class="card z-depth-2 mt-3" id="cartao-requisicoes">
            
            <div class="card-header default-color-dark white-text">Requisições</div>

            <div class="card-body">
                
                <div class="container">
                    <?php
                    
                        $usuarios_temp = recuperar_usuarios_temp($conexao);
                
                        if (count($usuarios_temp) > 0) {
                    ?>
                    
                            <table class="table table-hover" id="tabela-requisicoes">
                                <thead>
                                    <th class="font-weight-bold t-nome-usuario">Nome</th>
                                    <th class="font-weight-bold t-sobrenome-usuario">Criado Em</th>
                                    <th class="font-weight-bold t-username-usuario">Usuário</th>
                                    <th class="font-weight-bold t-email-usuario">E-mail</th>
                                    <th class="font-weight-bold">Operações</th>
                                </thead>
                
                                <tbody>
                                <?php    
                                    foreach ($usuarios_temp as $usuario_temp) {
                                ?>
                                    <tr>
                                        <td class="t-nome-usuario"><?= $usuario_temp['Nome'] ?></td>
                                        <td class="t-sobrenome-usuario"><?= $usuario_temp['Criado_Em'] ?></td>
                                        <td class="t-username-usuario"><?= $usuario_temp['Usuario'] ?></td>
                                        <td class="t-email-usuario"><?= $usuario_temp['Email'] ?></td>
                                        <td>
                                            <form action="scripts/adiciona-usuario-temp.php" method="post">
                                                <input type="hidden" name="id" value="<?= $usuario_temp['ID_Usuario'] ?>">
                                                <button class="btn btn-primary botao-pequeno">adicionar</button>
                                            </form>
                                            <form action="scripts/rejeitar-usuario-temp.php" method="post">
                                                <input type="hidden" name="email" value="<?= $usuario_temp['Email'] ?>">
                                                <button class="btn btn-danger botao-pequeno">rejeitar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                    
                    <?php
                        }
                        else {
                    ?>
                            <div class="alert alert-info" role="alert">Não existem requisições no momento.</div>
                    <?php
                        }
                    ?>
                </div>

            </div>
        </div>
        <?php
            }
        ?>

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
<script src="js/grupos.js"></script>


<script>


    // =======================================================
    // Ao carregar a página
    // =======================================================

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


</script>