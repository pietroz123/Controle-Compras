<section class="container text-left">

<?php

    function human_filesize($bytes, $decimals = 2) {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    $i = 0;
    foreach (glob("backups/*.sql") as $filename) {
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
                <button class="btn btn-info botao botao-pequeno" style="max-width: 10em;" nome-arquivo="<?= explode("/", $nome)[1] ?>">visualizar</button>
                <button class="btn btn-danger botao botao-pequeno" style="max-width: 10em;" nome-arquivo="<?= explode("/", $nome)[1] ?>">remover</button>
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