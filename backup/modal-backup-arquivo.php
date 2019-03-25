<?php

if ( (isset($_POST['visualizar']) && $_POST['visualizar'] == "sim") && (isset($_POST['nomeArquivo'])) ) {

    $nome_arquivo = "backups/" . $_POST['nomeArquivo'];
    $conteudo = file_get_contents($nome_arquivo);

?>

    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document" id="backup-arquivo">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <h6 class="modal-title w-100" id="myModalLabel"><?= $nome_arquivo ?></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!--Body-->
            <div class="modal-body">
                <pre class="prettyprint lang-sql p-4"><?= $conteudo ?></pre>
            </div>
            <!--Footer-->
            <div class="modal-footer">
                <a href="<?= $nome_arquivo ?>" class="btn btn-default botao waves-effect waves-light" download>download</a>
                <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">fechar</button>
            </div>
        </div>
        <!--/.Content-->
    </div>

<?php
}
?>