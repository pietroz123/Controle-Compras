<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/database/conexao.php';

    verifica_usuario();
    verifica_admin();
    mostra_alertas();
?>

    <h1>Controle de Backups</h1>

    <div class="card">
        <div class="card-body">

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
                </article>
            
            </section>

        </div>
    </div>


<?php
    include $_SERVER['DOCUMENT_ROOT'].'/rodape.php';
?>