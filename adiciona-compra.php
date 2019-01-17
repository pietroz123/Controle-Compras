<?php 
    include("cabecalho.php");
    include("database/conexao.php");
    include("funcoes.php");
?>

<?php
    verifica_usuario();
?>

<!-- Recebe as requisições de formulario-compra.php -->
<?php 

    if (isset($_POST['submit-form-compra'])) {

        
    // Variáveis da compra
    $valor              = $_POST['valor'];
    $data               = $_POST['data'];
    $observacoes        = $_POST['observacoes'];
    $desconto           = $_POST['desconto'];
    $forma_pagamento    = $_POST['forma-pagamento'];
    $comprador_id       = $_POST['comprador-id'];
    

    // Variáveis da imagem
    $imagem             = $_FILES['imagem'];
    $imagem_nome        = $_FILES['imagem']['name'];
    $imagem_nome_tmp    = $_FILES['imagem']['tmp_name'];
    $imagem_tamanho     = $_FILES['imagem']['size'];
    $imagem_erro        = $_FILES['imagem']['error'];
    $imagem_tipo        = $_FILES['imagem']['type'];

    // Inicializa o novo nome com 'null'
    $novo_nome = '';

    // Recupera a extensão do arquivo (para verificar se é JPG ou PNG)
    $extensao = explode('.', $imagem_nome); // Divide a string e pega apenas a parte a partir do '.'
    $ext = strtolower(end($extensao));      // Converte tudo pra letra minuscula e pega apenas depois do '.'

    // Extensões permitidas
    $permitido = array('jpg', 'jpeg', 'png');

    // Verifica se uma imagem foi enviada
    if (is_uploaded_file($_FILES['imagem']['tmp_name'])) {
        // Verifica se a extensão é uma imagem
        if (in_array($ext, $permitido)) {
            // Verifica se não houve erros
            if ($imagem_erro === 0) {
                // Verifica se o tamanho está dentro do aceitado
                // $kb = 1024;
                // $tamanho_permitido = 500 * $kb;
                // if ($imagem_tamanho < $tamanho_permitido) {
                    // Cria um nome único para a imagem
                    // $novo_nome = uniqid('', true) . '.' . $ext;
                    $novo_nome = uniqid('') . "-" . $observacoes . "-" . $data . "." . $ext;
                    
                    // Destino do imagem
                    $destino = "img/uploads/compras/" . $novo_nome;
    
                    // Armazena a imagem
                    move_uploaded_file($imagem_nome_tmp, $destino);
    
                    $novo_destino = comprimir($destino, "img/uploads/compras/" . $novo_nome, 20);
                    move_uploaded_file($destino, $novo_destino);
    
                    // echo "<p>Temp: " . $imagem_nome_tmp . "</p>";
                    // echo "<p>Novo_Nome: " . $novo_nome . "</p>";  
                    // echo "<p>Destino: " . $destino . "</p>";  
                    // echo "<p>Novo_Destino: " . $novo_destino . "</p>";  
                    
                    $_SESSION['success'] = "Imagem salva com sucesso.";
                // }
                // else {
                    
                //     $_SESSION['danger'] = "O tamanho da imagem ultrapassa '" . $tamanho_permitido . "!";
                // }
            }
            else { // Erro no upload da imagem
                $_SESSION['danger'] = "Ocorreu um erro no upload da imagem!"; 
            }
        }
        else { // Não está nas extensões permitidas
            $_SESSION['danger'] = "Essa extensão não é permitida!";
        }
    }
    else { // $novo_nome é vazio
        $_SESSION['info'] = "Nenhuma imagem selecionada.";
    }


    mostra_alerta("danger");
    mostra_alerta("success");
    mostra_alerta("info");
?>

<!-- Abre conexão e verifica possível erro -->
<?php 

    if (inserir_compra($conexao, $valor, $data, $observacoes, $desconto, $forma_pagamento, $comprador_id, $novo_nome)) {        

?>

        <!-- Alerta de sucesso -->
        <div class="alert alert-success" role="alert">
            <p>
                Compra (<?= $valor; ?>, <?= $data; ?>, <?= $observacoes; ?>, <?= $desconto; ?>, <?= $forma_pagamento; ?>, <?= $comprador_id; ?>) adicionada com sucesso!
            </p>
            <hr>
            <p class="mb-0">
                <a href="formulario-compra-grid.php" class="alert-link">Inserir Outra Compra</a>
            </p>
        </div>

<!-- Else -->
<?php 
    } else {
        $mensagem_erro = mysqli_error($conexao);
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



<?php include("rodape.php"); ?>