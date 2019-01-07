<div class="modal" id="modal-cadastro">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Formulario de Cadastro</h2>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="cadastro.php" method="post">
                <div class="modal-body">
                    <div class="grid">
                        <div class="row">
                            <div class="col-sm-4">E-mail</div>
                            <div class="col-sm-8"><input type="email" name="email" class="form-control" placeholder="Digite seu email"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Senha</div>
                            <div class="col-sm-8"><input type="password" name="senha" class="form-control" placeholder="Digite sua senha"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Repita a senha</div>
                            <div class="col-sm-8"><input type="password" name="senha-rep" class="form-control" placeholder="Repita sua senha"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-cyan btn-block">cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>