<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';

    verifica_usuario();

    // Recebe os dados da pesquisa

    if (isset($_GET['submit-buscar']) && $_GET['submit-buscar'] == "true") {

        $palavraChave = $_GET['texto'];
        $datas = $_GET['data-range'];

        if (!empty($datas)) {
            $datas = explode(' - ', $datas);
            $dataInicio = implode('-', array_reverse(explode('/', $datas[0])));
            $dataFim    = implode('-', array_reverse(explode('/', $datas[1])));
        }
        else {
            $dataInicio = '';
            $dataFim    = '';
        }

        $id_comprador = $_GET['comprador'];
        $soma = 0;

?>

    <h1 class="titulo-site">Resultado da Busca</h1>

    <table class="table table-hover" id="tabela-compras">
        
        <thead class="thead-dark">
            <tr>
                <th class="th-sm t-id">ID</th>
                <th class="th-sm t-data">Data</th>
                <th class="th-sm t-observacoes">Observacoes</th>
                <th class="th-sm t-valor">Valor</th>
                <th class="th-sm t-desconto">Desconto</th>
                <th class="th-sm t-pagamento">Pagamento</th>
                <th class="th-sm t-comprador">Comprador</th>
                <th class="t-imagem">Imagem</th>
                <th class="th-sm t-alterar">Alterar</th>
                <th class="th-sm t-remover">Remover</th>
                <th class="th-sm t-detalhes">Detalhes</th> 
            </tr>
        </thead>

        <tbody>
        <?php

            // Se foi selecionada a opção TODOS
            if ($id_comprador == 0) {
                $compras = compras_permitidas_like($conexao, $_SESSION['login-username'], $_SESSION['login-email'], $palavraChave, $dataInicio, $dataFim);
            }
            // Caso não tenha sido selecionado um range de datas
            else if (empty($datas)) {
                $compras = listar($conexao, "SELECT cmp.*, cmpd.Nome AS Nome_Comprador FROM compras AS cmp JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID WHERE observacoes LIKE '%{$palavraChave}%' AND Comprador_ID = {$id_comprador} ORDER BY year(data), month(data), day(data) DESC");
            }
            // Caso tenha sido selecionado um comprador e um range de datas
            else {
                $compras = listar($conexao, "SELECT cmp.*, cmpd.Nome AS Nome_Comprador FROM compras AS cmp JOIN compradores AS cmpd ON cmp.Comprador_ID = cmpd.ID WHERE observacoes LIKE '%{$palavraChave}%' AND data >= '{$dataInicio}' AND data <= '{$dataFim}' AND Comprador_ID = {$id_comprador} ORDER BY year(data), month(data), day(data) DESC");
            }

            foreach ($compras as $compra) :
                $valor = $compra['Valor'];
                $soma += $valor;
        ?>

            <tr>
                <td class="t-id"><?= $compra['Id'] ?></td>
                <td class="t-data"><?= $compra['Data'] ?></td>
                <td class="t-observacoes"><?= $compra['Observacoes'] ?></td>
                <td class="t-valor"><?= $compra['Valor'] ?></td>
                <td class="t-desconto"><?= $compra['Desconto'] ?></td>          
                <td class="t-pagamento"><?= $compra['Forma_Pagamento'] ?></td>
                <td class="t-comprador"><?= $compra['Nome_Comprador'] ?></td>
                <td class="t-imagem">
                    <button type="button" class="btn light-blue btn-block botao-pequeno btn-imagem" id="<?= $compra['Id'] ?>">imagem</button>
                </td>
                <td class="t-alterar">
                    <form action="formulario-alterar-compra.php" method="post">
                        <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
                        <button class="btn btn-primary botao-pequeno">alterar</button>
                    </form>
                </td>
                <td class="t-remover">
                    <form action="scripts/remover-compra.php" method="post">
                        <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
                        <button class="btn btn-danger botao-pequeno" type="submit" name="submit-remover" onclick="return confirm(\'Deseja prosseguir com a remoção?\');">remover</button>
                    </form>
                </td>
                <td class="t-detalhes">
                    <button type="button" id="<?= $compra['Id'] ?>" class="btn btn-info botao-pequeno btn-detalhes">detalhes</button>
                </td>
            </tr>

        <?php
            endforeach
        ?>
        </tbody>

    </table><br>

    <div class="box p-3 mb-2 bg-info text-white bold">
        SOMA = <?= $soma; ?>
    </div>


    <!-- Modal para detalhes da Compra -->
    <div class="modal" id="modal-detalhes-compra">
        <div class="modal-dialog" id="detalhes-compra">
            <!-- Preenchido com AJAX (JS) -->
        </div>
    </div>

    <!-- Modal para imagem da Compra -->
    <div class="modal" id="modal-imagem-compra">
        <div class="modal-dialog" id="imagem-compra">
            <!-- Preenchido com AJAX (JS) -->        
        </div>
    </div>



    <?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>
    <script src="js/tabela-compras.js"></script>

    <script>

        // =======================================================
        // Manipulacao de tabelas em tabela-compras.js
        // =======================================================

    </script>

<?php
    }
?>
