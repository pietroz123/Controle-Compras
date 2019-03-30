<div class="modal" id="modal-login">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Formulario de Login</h2>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="scripts/login.php" method="post">
                <div class="modal-body">
                    <div class="grid">
                        <div class="row">
                            <div class="col-sm-4">E-mail/Usuário</div>
                            <div class="col-sm-8"><input type="text" name="autenticacao" class="form-control" placeholder="Digite seu email/nome de usuário"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">Senha</div>
                            <div class="col-sm-8"><input type="password" name="senha" class="form-control" placeholder="Digite sua senha"></div>
                        </div>
                        <a href="recuperacao-senha.php" class="text-danger">Esqueceu sua senha?</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit-login" class="btn btn-cyan btn-block">login</button>
                </div>
            </form>
        </div>
    </div>
</div>