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

        <p>Este projeto corresponde à uma integração entre <mark>PHP</mark> e <mark>MySQL</mark> para gerenciar um Banco de Dados cujo objetivo é armazenar minhas compras pessoais, além de seus respectivos compradores.</p>

        <p>O Sistema de Gestão de Bancos de Dados utilizado é o MySQL versão <mark>8.0.12-standard</mark>.</p>

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
                    <button class="btn btn-success botao botao-pequeno mb-4" type="submit">realizar backup</button>
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
                                    <div class="col-sm-12 mb-3">
                                        <article class="arquivo">
                                            <div><?= $nome ?></div>
                                            <div class="font-small font-weight-bold"><?= $data_criacao ?></div>
                                            <div class="font-small font-weight-bold"><?= $tamanho ?></div>
                                        </article>
                                    </div>
                                    <div class="col">
                                        <article class="operacoes d-flex justify-content-center">
                                            <button class="btn btn-info botao botao-pequeno">visualizar</button>
                                            <button class="btn btn-danger botao botao-pequeno">remover</button>
                                        </article>
                                    </div>
                                </div>
                                <hr>
                    
                        <?php
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