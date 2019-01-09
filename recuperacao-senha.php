<?php
    include("cabecalho.php");
?>

    <h1>Formulário de troca de senha</h1>
    <p class="alert alert-info" style="text-align: center;">Um e-mail lhe será enviado com as informações de como trocar sua senha</p>

    <form action="requisicao-recuperacao.php" class="formulario-recuperacao-senha" method="post">
        <div class="grid">
            <div class="row">
                <div class="col-md-5">E-mail para recuperação</div>
                <div class="col-md-7"><input type="email" name="email" placeholder="Digite seu e-mail" class="form-control"></div>
            </div>
        </div>
        <hr>
        <button type="submit" name="submit" class="btn btn-primary">receber nova senha por e-mail</button>
    </form>
    

<?php
    include("rodape.php");
?>