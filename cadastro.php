<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
?>


<form action="scripts/cadastrar.php" method="post" id="form-cadastro">
    <h1>Formulario de Cadastro</h1>
    <div class="grid grid-cadastro">
        <div class="row">
            <!-- col col-sm col-md col-lg col-xl -->
            <div class="col-sm-1 col-md-2">Nome</div>
            <div class="col-sm-5 col-md"><input type="text" name="nome" class="form-control" placeholder="Digite o seu primeiro nome" required></div>
        </div>
        <div class="row">
            <div class="col-sm-1 col-md-2">CPF</div>
            <div class="col-sm-5 col-md-4"><input type="text" name="cpf" class="form-control" placeholder="Digite seu CPF" id="input-cpf" maxlength="14" required></div>
            <div class="col-sm-1 col-md-1">CEP</div>
            <div class="col-sm-2 col-md"><input type="text" name="cep" class="form-control" placeholder="CEP" id="input-cep" maxlength="9" required></div>
        </div>
        <div class="row">
            <div class="col-sm-1 col-md-2">End.</div>
            <div class="col-sm-11 col-md"><input type="text" name="endereco" class="form-control" placeholder="Digite seu endereço" required></div>
        </div>
        <div class="row">
            <div class="col-sm-1 col-md-2">Cidade</div>
            <div class="col-sm-4 col-md"><input type="text" name="cidade" class="form-control" placeholder="Digite sua cidade" required></div>
            <div class="col-sm-1 col-md-2 col-lg-1">Estado</div>
            <div class="col-sm-3 col-md"><input type="text" name="estado" class="form-control" placeholder="Estado" required></div>
        </div>
        <div class="row">
            <div class="col-sm-1 col-md-2">Email</div>
            <div class="col-sm-5 col-md"><input type="email" name="email" class="form-control" placeholder="Digite seu e-mail" required></div>
        </div>
        <div class="row">
            <div class="col-sm-1 col-md-2">Tel. Cel.</div>
            <div class="col-sm-5 col-md"><input type="tel" name="telefone" class="form-control" placeholder="Digite seu telefone" id="input-telefone" maxlength="15" required></div>
            <div class="col-sm-1 col-md-2 col-lg-2">Tel. Res.</div>
            <div class="col-sm-5 col-md"><input type="tel" name="telefone-res" class="form-control" placeholder="Digite seu telefone" id="input-telefone-res" maxlength="15" required></div>
        </div>
        <hr>
        <div class="entrada-usuario">
            <div class="row">
                <div class="col-sm-2 col-md-">Usuário</div>
                <div class="col-sm-10 col-md-">
                    <input type="text" name="usuario" class="form-control" placeholder="Escolha um nome de usuário" minlength="4" id="input-usuario-cadastro" required>
                    <ul class="input-requirements">
                        <li>Pelo menos 4 caracteres</li>
                        <li>Apenas letras e números</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="entrada-senha">
            <div class="row">
                <div class="col-sm-2 col-md-">Senha</div>
                <div class="col-sm-10 col-md-">
                    <input type="password" name="senha" class="form-control" placeholder="Digite uma senha" autocomplete="off" minlength="5" maxlength="20" id="input-senha-cadastro" required>
                    <ul class="input-requirements">
                        <li>Pelo menos 5 caracteres</li>
                        <li>Pelo menos 1 número</li>
                        <li>Pelo menos 1 letra minúscula</li>
                        <li>Pelo menos 1 letra maiúscula</li>
                        <li>Pelo menos 1 caractere especial</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">Repita a senha</div>
            <div class="col-sm-10"><input type="password" name="senha-rep" class="form-control" placeholder="Repita a senha" id="input-senha-rep-cadastro" required></div>
        </div>
    </div>
    <hr>
    <button type="submit" name="submit" class="btn btn-cyan btn-block">cadastrar</button>
</form>


<?php
    include $_SERVER['DOCUMENT_ROOT'].'/rodape.php';
?>