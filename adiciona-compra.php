<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
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
    $forma_pagamento    = $_POST['forma-pagamento'];
    $comprador_id       = $_POST['comprador-id'];

    // Verifica se existem categorias e subcategorias
    if (isset($_POST['categoria'])) {
        $categoria = $_POST['categoria'];
        if (isset($_POST['subcategorias']))
            $subcategorias = $_POST['subcategorias'];
        else
            $subcategorias = '';
    } else
        $categoria = '';


    $data = implode('-', array_reverse(explode('/', $data)));


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
        
        $novo_nome = uniqid('') . "-" . $observacoes . "-" . $data . "." . $ext;
        
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

    if (inserir_compra($dbconn, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id, $novo_nome, $categoria, $subcategorias)) {        

?>

        <!-- Alerta de sucesso -->
        <div class="alert alert-success" role="alert">
            <p>
                Compra (<?= $valor; ?>, <?= $data; ?>, <?= $observacoes; ?>, <?= $desconto; ?>, <?= $forma_pagamento; ?>, <?= $comprador_id; ?>) adicionada com sucesso!
            </p>
            <hr>
            <p class="mb-0">
                <a href="formulario-compra.php" class="alert-link">Inserir Outra Compra</a>
            </p>
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