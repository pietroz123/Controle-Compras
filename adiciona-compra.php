<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';

    include $_SERVER['DOCUMENT_ROOT'].'/persistence/CategoriaSubcategoriaDAO.php';
    include $_SERVER['DOCUMENT_ROOT'].'/persistence/CompradorDAO.php';
?>

<?php
    verifica_usuario();
?>

<!-- Recebe as requisições de formulario-compra.php -->
<?php 

    if (isset($_POST['submit-form-compra'])) {

        
    // Variáveis da compra (obrigatórias)
    $valor              = $_POST['valor'];
    $data               = $_POST['data'];
    $observacoes        = $_POST['observacoes'];
    $desconto           = $_POST['desconto'];
    $forma_pagamento    = $_POST['select-forma-pagamento'];
    $comprador_id       = $_POST['comprador-id'];
    $categoria          = $_POST['categoria'];
    $subcategorias      = isset($_POST['subcategorias']) ? $_POST['subcategorias'] : NULL;


    $data_formatada = implode('-', array_reverse(explode('/', $data)));


    // Variáveis da imagem
    $imagem             = $_FILES['imagem'];
    $imagem_nome        = $_FILES['imagem']['name'];
    $imagem_nome_tmp    = $_FILES['imagem']['tmp_name'];
    $imagem_tamanho     = $_FILES['imagem']['size'];
    $imagem_erro        = $_FILES['imagem']['error'];
    $imagem_tipo        = $_FILES['imagem']['type'];

    // Inicializa o novo nome com 'null'
    $novo_nome = '';

    if (isset($_POST['imagem-cortada']) && !empty($_POST['imagem-cortada'])) {

        $imagem_cortada     = $_POST['imagem-cortada'];

        // Recupera a extensão do arquivo (para verificar se é JPG ou PNG)
        $extensao = explode('.', $imagem_nome); // Divide a string e pega apenas a parte a partir do '.'
        $ext = strtolower(end($extensao));      // Converte tudo pra letra minuscula e pega apenas depois do '.'

        // Mantem apenas a string da imagem
        $imagem_cortada = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imagem_cortada));
        
        $novo_nome = uniqid('') . "-" . $observacoes . "-" . $data_formatada . "." . $ext;
        
        // Destino do imagem
        $destino = "../private/uploads/compras/" . $novo_nome;
    
        // Salva a imagem
        file_put_contents($destino, $imagem_cortada);
        $novo_destino = comprimir($destino, "../private/uploads/compras/" . $novo_nome, 20);
        move_uploaded_file($destino, $novo_destino);
    
        $_SESSION['success'] = "Imagem salva com sucesso.";

    }
    else {
        $_SESSION['info'] = "Nenhuma imagem selecionada.";
    }


    mostra_alertas();
?>

<!-- Abre conexão e verifica possível erro -->
<?php 

    if (inserir_compra($dbconn, $valor, $data_formatada, $observacoes, $desconto, $forma_pagamento, $comprador_id, $novo_nome, $categoria, $subcategorias)) {        

?>

        <!-- Alerta de sucesso -->

        <div class="alert alert-success">
            <div id="detalhes-compra">
                <div class="container">
                    <div class="row">
                        <div class="col"><h4>Compra Adicionada com Sucesso</h4></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col"><h5>Detalhes da Compra:</h5></div>
                    </div>
                    <div class="row row-detalhe">
                        <div class="col label-detalhes-compra">Observações:</div>
                        <div class="col"><?= $observacoes ?></div>
                    </div>
                    <div class="row row-detalhe">
                        <div class="col label-detalhes-compra">Data:</div>
                        <div class="col"><?= $data ?></div>
                    </div>
                    <div class="row row-detalhe">
                        <div class="col label-detalhes-compra">Categoria:</div>
                        <div class="col"><span class="badge badge-pill badge-light"><?= CategoriaSubcategoriaDAO::recuperarCategoria($dbconn, $categoria)['Nome_Categoria'] ?></span></div>
                    </div>
                    <div class="row row-detalhe">
                        <div class="col label-detalhes-compra">Subcategoria:</div>
                        <div class="col">
                            <?php 
                                if (!empty($subcategorias)) {
                                    foreach ($subcategorias as $subcategoria) { 
                            ?>
                                        <span class="badge badge-pill badge-light"><?= CategoriaSubcategoriaDAO::recuperarSubcategoria($dbconn, $subcategoria)['Nome_Subcategoria'] ?></span>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="row row-detalhe">
                        <div class="col label-detalhes-compra">Valor:</div>
                        <div class="col">R$<?= $valor ?></div>
                    </div>
                    <div class="row row-detalhe">
                        <div class="col label-detalhes-compra">Desconto:</div>
                        <div class="col">R$<?= $desconto ?></div>
                    </div>
                    <div class="row row-detalhe">
                        <div class="col label-detalhes-compra">Forma de Pagamento:</div>
                        <div class="col">
                        <?php
                            switch ($forma_pagamento) {
                                case 'cartao':
                                    echo 'Cartão';
                                    break;
                                case 'boleto':
                                    echo 'Boleto';
                                    break;
                                case 'dinheiro':
                                    echo 'Dinheiro';
                                    break;
                                case 'refeicao':
                                    echo 'Refeição';
                                    break;
                                case 'alimentacao':
                                    echo 'Alimentação';
                                    break;
                            }
                        ?>
                        </div>
                    </div>
                    <div class="row row-detalhe">
                        <div class="col label-detalhes-compra">Comprador:</div>
                        <div class="col"><?= CompradorDAO::recuperarComprador($dbconn, $comprador_id)['Nome'] ?></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col d-flex justify-content-center"><a href="formulario-compra.php" class="alert-link">Inserir Outra Compra</a></div>
                    </div>
                </div>
            </div>
        </div>

<!-- Else -->
<?php 
    } else {
        $mensagem_erro = $dbconn->errorInfo();
?>

        <!-- Alerta de erro -->
        <div class="alert alert-danger">
            <h2 class="alert-heading">Erro na adição da Compra</h2>
            <p>
                <?= $mensagem_erro; ?>
            </p>
        </div>

<!-- Fecha a conexão -->
<?php
    }
    }
?>



<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>