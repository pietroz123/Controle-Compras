<div class="modal fade" id="modal-cadastro">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Formulario de Cadastro</h2>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="scripts/cadastro.php" method="post" id="form-cadastro">
                <div class="modal-body">
                    <div class="grid">
                        <div class="row">
                            <div class="col-sm-1">Nome</div>
                            <div class="col-sm-5"><input type="text" name="nome" class="form-control" placeholder="Digite o seu primeiro nome"></div>
                            <div class="col-sm-1">CPF</div>
                            <div class="col-sm-5"><input type="text" name="cpf" class="form-control" placeholder="Digite seu CPF" id="input-cpf" maxlength="14"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">CEP</div>
                            <div class="col-lg-2"><input type="text" name="cep" class="form-control" placeholder="CEP" id="input-cep" maxlength="9"></div>
                            <div class="col-lg-1">Cidade</div>
                            <div class="col-lg-4"><input type="text" name="cidade" class="form-control" placeholder="Digite sua cidade"></div>
                            <div class="col-lg-1">Estado</div>
                            <div class="col-lg-3"><input type="text" name="estado" class="form-control" placeholder="Estado"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">End.</div>
                            <div class="col-lg-11"><input type="text" name="endereco" class="form-control" placeholder="Digite seu endereço"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1">Email</div>
                            <div class="col-sm-5"><input type="email" name="email" class="form-control" placeholder="Digite seu e-mail"></div>
                            <div class="col-sm-1">Tel.</div>
                            <div class="col-sm-5"><input type="tel" name="telefone" class="form-control" placeholder="Digite seu telefone" id="input-telefone" maxlength="15"></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-2">Usuário</div>
                            <div class="col-sm-10"><input type="text" name="usuario" class="form-control" placeholder="Escolha um nome de usuário"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">Senha</div>
                            <div class="col-sm-10"><input type="password" name="senha" class="form-control" placeholder="Digite uma senha"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">Repita a senha</div>
                            <div class="col-sm-10"><input type="password" name="senha-rep" class="form-control" placeholder="Repita a senha"></div>
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