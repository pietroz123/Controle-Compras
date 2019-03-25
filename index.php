<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
?>

<?php
    mostra_alertas();
?>
<?php
    if (!usuario_esta_logado()) {
?>

        <h1>Bem Vindo ao Controle de Compras</h1>

        <p class="bem-vindo-index">Este projeto corresponde à uma integração entre <mark>PHP</mark> e <mark>MySQL</mark> para gerenciar um Banco de Dados cujo objetivo é armazenar minhas compras pessoais, além de seus respectivos compradores.</p>

        <p class="bem-vindo-index">O Sistema de Gestão de Bancos de Dados utilizado é o MySQL versão <mark>8.0.12-standard</mark>.</p>

        <div class="alert alert-warning">Efetue o login ou o cadastro à partir do Menu de Navegação.</div>
        
        <div class="redes">
            <ul class="list-inline">
                <li class="list-inline-item"><a href="https://github.com/pietroz123"><img src="img/github.png" class="medium-icon" alt="Github"></a></li>
                <li class="list-inline-item"><a href="https://www.linkedin.com/in/pietro-zuntini-b23506140/"><img src="img/linkedin.png" class="medium-icon" alt="Linkedin"></a></li>
                <li class="list-inline-item"><a href="https://gitlab.com/pietroz123"><img src="img/gitlab.png" class="medium-icon" alt="Gitlab"></a></li>
            </ul>
        </div>

<?php
    } else {
?>

        <h3 class="text-left">Bem Vindo de Volta, <?= $_SESSION['login-nome'] ?></h3>
        <hr class="mb-5">

        <div class="alert alert-info">Logado como <?= usuario_logado(); ?></div>

        <!-- Cartão de informações -->
        <div class="card">
            <div class="card-body p-2">

                <div class="card-header elegant-color-dark py-4 white-text text-uppercase">
                    <div class="card-title" id="titulo-informacoes">Informações</div>
                </div>
                
                <section id="informacoes" class="d-flex align-content-center flex-wrap">

                    <?php
                        // Recupera o número de usuários
                        $sql = "SELECT * FROM `usuarios`";
                        $resultado = mysqli_query($conexao, $sql);
                        $nUsuarios = mysqli_num_rows($resultado); 

                    ?>
                    <article class="cartao-informacao">
                        <b class="cartao-informacao-titulo">Número de Usuários</b>
                        <div class="cartao-informacao-desc"><?= $nUsuarios; ?></div>
                        <a href="#!" class="botao botao-pequeno btn btn-light">visualizar</a>
                    </article>

                    <?php
                        // Recupera o número de grupos
                        $sql = "SELECT * FROM `grupos`";
                        $resultado = mysqli_query($conexao, $sql);
                        $nGrupos = mysqli_num_rows($resultado); 
                        
                    ?>
                    <article class="cartao-informacao">
                        <b class="cartao-informacao-titulo">Número de Grupos</b>
                        <div class="cartao-informacao-desc"><?= $nGrupos; ?></div>
                        <a href="perfil-usuario.php#cartao-grupos-usuario" class="botao botao-pequeno btn btn-light">visualizar</a>
                    </article>

                    <?php
                        // Recupera o número de usuários não autenticados
                        $sql = "SELECT * FROM `usuarios` WHERE `Autenticado` = 0";
                        $resultado = mysqli_query($conexao, $sql);
                        $nRequisicoes = mysqli_num_rows($resultado); 
                        
                    ?>
                    <article class="cartao-informacao">
                        <b class="cartao-informacao-titulo">Número de Requisições</b>
                        <div class="cartao-informacao-desc"><?= $nRequisicoes; ?></div>
                        <a href="perfil-usuario.php#cartao-requisicoes" class="botao botao-pequeno btn btn-light">visualizar</a>
                    </article>

                    <?php
                        // Recupera o número de compras
                        $sql = "SELECT * FROM `compras`";
                        $resultado = mysqli_query($conexao, $sql);
                        $nCompras = mysqli_num_rows($resultado); 
                        
                    ?>
                    <article class="cartao-informacao">
                        <b class="cartao-informacao-titulo">Número de Compras</b>
                        <div class="cartao-informacao-desc"><?= $nCompras; ?></div>
                        <a href="listar-compras.php#tabela-compras" class="botao botao-pequeno btn btn-light">visualizar</a>
                    </article>

                    <?php
                        // Recupera o número de backups
                        // $sql = "SELECT * FROM `usuarios`";
                        // $resultado = mysqli_query($conexao, $sql);
                        // $nUsuarios = mysqli_num_rows($resultado); 
                        
                    ?>
                    <article class="cartao-informacao">
                        <b class="cartao-informacao-titulo">Número de Backups</b>
                        <div class="cartao-informacao-desc">0</div>
                        <a href="#!" class="botao botao-pequeno btn btn-light">visualizar</a>
                    </article>
                
                </section>

            </div>
        </div>


        <div class="card mt-5" id="cartao-backups">
            <div class="card-body p-2">
                
                <div class="card-header elegant-color-dark py-4 white-text text-uppercase">
                    <div class="card-title" id="titulo-informacoes">Backup</div>
                </div>

                <div class="elegant-color p-3" id="backups">

                    <!-- Realizar Backup -->
                    <!-- <form action="backup/myphp-backup.php"> -->
                        <button class="btn btn-success botao botao-pequeno mb-4 btn-backup">clique aqui para realizar backup</button>
                        <div id="resultado-backup" class="bg-white mb-3" style="display: none;">
                            <div class="container p-2">
                                <div class="row">
                                    <div class="col opcao-backup-intro text-uppercase"><p>Realizar Backup de:</p></div>
                                </div>

                                <hr>

                                <div class="row mb-3">
                                    <div class="col opcao-backup-titulo">TABELAS:</div>
                                    <div class="col opcao-backup-titulo">INFORMAÇÕES:</div>
                                </div>

                                <div class="row" id="tabelas-backup">

                                    <!-- Checkboxes das Tabelas -->
                                    <form class="col d-flex flex-column text-left ml-4" id="formTabelas">
                                        <div class="custom-control custom-checkbox chk-tabelas opcao-backup">
                                            <input type="checkbox" class="custom-control-input" name="chk_tb" id="chk_tb_todas" value="todas">
                                            <label class="custom-control-label" for="chk_tb_todas">Todas</label>
                                        </div>
                                        <?php
                                            $show = "SHOW TABLES";
                                            $resultado = mysqli_query($conexao, $show);
                                            $tables = array();
                                            while ($table = mysqli_fetch_assoc($resultado)) {
                                        ?>
                                                <div class="custom-control custom-checkbox chk-tabelas opcao-backup">
                                                    <input type="checkbox" class="custom-control-input" name="chk_tb" id="chk-<?= $table['Tables_in_my_controle_compras'] ?>" value="<?= $table['Tables_in_my_controle_compras'] ?>">
                                                    <label class="custom-control-label" for="chk-<?= $table['Tables_in_my_controle_compras'] ?>"><?= strtoupper($table['Tables_in_my_controle_compras']) ?></label>
                                                </div>
                                        <?php
                                            }
                                        ?>
                                    </form>
                                    <!-- Checkboxes das Tabelas -->

                                    <!-- Checkboxes das Opções -->
                                    <form class="col d-flex flex-column text-left ml-4" id="formOpcoes">
                                        <div class="custom-control custom-checkbox chk-informacoes opcao-backup">
                                            <input type="checkbox" class="custom-control-input" name="chk_info" id="chk_info_todas" value="todas">
                                            <label class="custom-control-label" for="chk_info_todas">Todas</label>
                                        </div>
                                        <div class="custom-control custom-checkbox chk-informacoes opcao-backup">
                                            <input type="checkbox" class="custom-control-input" name="chk_info" id="chk-dados" value="dados">
                                            <label class="custom-control-label" for="chk-dados">Dados</label>
                                        </div>
                                        <div class="custom-control custom-checkbox chk-informacoes opcao-backup">
                                            <input type="checkbox" class="custom-control-input" name="chk_info" id="chk-estrutura" value="estrutura">
                                            <label class="custom-control-label" for="chk-estrutura">Estrutura</label>
                                        </div>
                                    </form>
                                    <!-- Checkboxes das Opções -->

                                </div>

                                <hr>

                                <!-- Botão de OK -->
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-success float-right" id="btn-ok-backup" type="submit" name="submit-backup">ok</button>
                                        <button class="btn btn-danger float-right" id="btn-cancelar-backup">cancelar</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <!-- </form> -->



                    <h4 class="white-text text-left py-2">Ultimos Backups</h4>
                    
                    <div id="ultimos-backups" class="bg-light py-4">
                        
                        <section class="container text-left">

                        <?php
                    
                            function human_filesize($bytes, $decimals = 2) {
                                $sz = 'BKMGTP';
                                $factor = floor((strlen($bytes) - 1) / 3);
                                return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
                            }
                    
                            $i = 0;
                            foreach (glob("backup/backups/*.sql") as $filename) {
                                $nome = $filename;
                                $data_criacao = date("d/m/Y H:i:s", filectime($filename));
                                $tamanho = human_filesize(filesize($filename));
                        ?>
                        
                                <div class="row">
                                    <div class="col mb-3">
                                        <article class="arquivo">
                                            <div><?= $nome ?></div>
                                            <div class="font-small font-weight-bold"><?= $data_criacao ?></div>
                                            <div class="font-small font-weight-bold"><?= $tamanho ?></div>
                                        </article>
                                    </div>
                                    <div class="col-12 col-md-3 d-flex justify-content-center flex-row flex-md-column">
                                        <button class="btn btn-info botao botao-pequeno" style="max-width: 10em;">visualizar</button>
                                        <button class="btn btn-danger botao botao-pequeno" style="max-width: 10em;">remover</button>
                                    </div>
                                </div>
                                <hr>
                    
                        <?php
                                $i++;
                            }
                            if ($i == 0) {
                        ?>
                                <div class="alert alert-info">Nenhum backup disponível no momento.</div>
                        <?php
                            }
                        ?>

                        </section>

                    </div>
                    <!-- ultimos-backups -->
                </div>

            </div>
        </div>

<?php
    }
?>


<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>


<script>

    // Salva as opcoes do backup para utilizacao posterior
    var opcoesBackup = $('#resultado-backup').html();

    
    // =======================================================
    // Botão Realizar Backup
    // =======================================================


    $(document).on('click', '.btn-backup', function() {
        $('#resultado-backup').slideDown();
    });

    $(document).on('click', '#btn-cancelar-backup', function() {
        $('#resultado-backup').slideUp();
    });

    $(document).on('click', '#btn-ok-backup', function() {

        var tabelas = [];
        $.each($("input[name='chk_tb']:checked"), function() {
            tabelas.push($(this).val());
        });

        var opcoes = [];
        $.each($("input[name='chk_info']:checked"), function() {
            opcoes.push($(this).val());
        });

        $.ajax({
            url: 'backup/myphp-backup.php',
            method: 'POST',
            data: {
                backup: "sim",
                tabelas: tabelas,
                opcoes: opcoes
            },
            success: function(retorno) {
                $('#resultado-backup').html(retorno);
                toastr.success('Backup realizado com sucesso!', '', {
                    positionClass: "toast-top-right"
                });
            },
            error: function(retorno) {
            }
        });
    });



    // ============================================================
    // Verificação das Checkbox - Javascript & JQuery Jon Ducket
    // ============================================================

    // Helper function to add an event listener
    function addEvent (el, event, callback) {
        if ('addEventListener' in el) {                  // If addEventListener works
            el.addEventListener(event, callback, false);   // Use it
        } else {                                         // Otherwise
            el['e' + event + callback] = callback;         // CreateIE fallback
            el[event + callback] = function () {
            el['e' + event + callback](window.event);
            };
            el.attachEvent('on' + event, el[event + callback]);
        }
    }

    // Para o form das Tabelas

    var formTabelas = document.getElementById('formTabelas');
    var elementosTabelas = formTabelas.elements;
    var opcoesTabelas = elementosTabelas.chk_tb;
    var inputTodasTabelas = document.getElementById('chk_tb_todas');

    function updateAllTabelas() {
        for (let i = 0; i < opcoesTabelas.length; i++) {
            opcoesTabelas[i].checked = inputTodasTabelas.checked;
        }
    }
    addEvent(inputTodasTabelas, 'change', updateAllTabelas);

    function clearAllOptionsTabelas(e) {
        var target = e.target || e.srcElement;
        if (!target.checked) {
            inputTodasTabelas.checked = false;
        }
    }
    for (let i = 0; i < opcoesTabelas.length; i++) {
        addEvent(opcoesTabelas[i], 'change', clearAllOptionsTabelas);
        
    }


    // Para o form das Opcoes

    var formOpcoes = document.getElementById('formOpcoes');
    var elementosOpcoes = formOpcoes.elements;
    var opcoesOpcoes = elementosOpcoes.chk_info;
    var inputTodasOpcoes = document.getElementById('chk_info_todas');

    function updateAllOpcoes() {
        for (let i = 0; i < opcoesOpcoes.length; i++) {
            opcoesOpcoes[i].checked = inputTodasOpcoes.checked;
        }
    }
    addEvent(inputTodasOpcoes, 'change', updateAllOpcoes);

    function clearAllOptionsOpcoes(e) {
        var target = e.target || e.srcElement;
        if (!target.checked) {
            inputTodasOpcoes.checked = false;
        }
    }
    for (let i = 0; i < opcoesOpcoes.length; i++) {
        addEvent(opcoesOpcoes[i], 'change', clearAllOptionsOpcoes);
        
    }




    // =======================================================
    // Botao de fechar progresso do backup
    // =======================================================

    $(document).on('click', '#btn-fechar-progresso', function() {

        $('#progresso-backup').remove();
        // Reseta o conteudo do resultado-backup
        $('#resultado-backup').html(opcoesBackup);

    });

</script>