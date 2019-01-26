<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/compras/cabecalho.php';
?>

<?php
    verifica_usuario();
?>

        <h1>Formulário de Adição de Comprador</h1>
        
        <form action="adiciona-comprador.php">
        
            <div class="grid">
            
                <div class="row">
                    <div class="col-lg-1">Nome</div>
                    <div class="col-lg-6"><input class="form-control" type="text" name="nome"></div>
                    <div class="col-lg-1">CPF</div>
                    <div class="col-lg-4"><input class="form-control" type="text" name="cpf"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-1">CEP</div>
                    <div class="col-lg-2"><input class="form-control" type="text" name="cep"></div>
                    <div class="col-lg-1">Endereço</div>
                    <div class="col-lg-8"><input class="form-control" type="text" name="endereco"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-1">Cidade</div>
                    <div class="col-lg-7"><input class="form-control" type="text" name="cidade"></div>
                    <div class="col-lg-1">Estado</div>
                    <div class="col-lg-3"><input class="form-control" type="text" name="estado"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-1">E-mail</div>
                    <div class="col-lg-6"><input class="form-control" type="email" name="email"></div>
                    <div class="col-lg-1">Telefone</div>
                    <div class="col-lg-4"><input class="form-control" type="tel" name="telefone"></div>
                </div>
                <hr>

            
            </div>
        
            <div><button class="btn btn-primary btn-block" type="submit">Adicionar</button></div>

        </form>


<?php include $_SERVER['DOCUMENT_ROOT'].'/compras/rodape.php'; ?>