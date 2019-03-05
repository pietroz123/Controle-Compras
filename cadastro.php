<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
?>
<link type="text/css" href="css/realtime-validation.css" rel="stylesheet">

<!-- <form action="scripts/cadastrar.php" method="post" id="form-cadastro" autocomplete="off">
    <h1>Formulario de Cadastro</h1>
    <div class="grid grid-cadastro">
        <div class="row">
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
    <div class="row">
        <div class="col">
            <button type="submit" name="submit" class="btn btn-cyan btn-block">cadastrar</button>
        </div>
    </div>
</form> -->

<form action="scripts/cadastrar.php" method="post" id="form-cadastro" autocomplete="off">
    
    <div class="card">
        
        <div class="card-header indigo white-text text-center align-items-center py-4">
            <h1 class="h1-responsive">Formulario de Cadastro</h1>    
        </div>        
        
        <div class="card-body grid grid-cadastro mt-3">
        
            <!-- Nome e E-mail -->
            <div class="form-row">
                <div class="col-sm-12 col-md-6">
                    <div class="md-form">
                        <i class="fas fa-user-circle prefix"></i>
                        <input type="text" name="nome" class="form-control" placeholder="Digite o seu primeiro nome" required>
                        <label for="nome">Primeiro Nome</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="md-form">
                        <i class="far fa-envelope prefix"></i>
                        <input type="email" name="email" class="form-control" placeholder="Digite seu e-mail" required>
                        <label for="email">E-mail</label>
                    </div>
                </div>
            </div>
        
        
        
            <div class="entrada-usuario">
                <div class="md-form">
                    <i class="fas fa-user prefix"></i>
                    <input type="text" name="usuario" class="form-control" placeholder="Escolha um nome de usuário" minlength="4" id="input-usuario-cadastro" required>
                        <ul class="input-requirements">
                            <li><small><i class="fas fa-caret-right"></i> Pelo menos 4 caracteres</small></li>
                            <li><small><i class="fas fa-caret-right"></i> Apenas letras e números</small></li>
                        </ul>
                    <label for="usuario">Username</label>
                </div>
            </div>
        
            <div class="entrada-senha">
                <div class="md-form">
                    <i class="fas fa-unlock prefix"></i>
                    <input type="password" name="senha" class="form-control" placeholder="Digite uma senha" autocomplete="off" minlength="5" maxlength="20" id="input-senha-cadastro" required>
                        <ul class="input-requirements">
                            <li><small><i class="fas fa-caret-right"></i> Pelo menos 5 caracteres</small></li>
                            <li><small><i class="fas fa-caret-right"></i> Pelo menos 1 número</small></li>
                            <li><small><i class="fas fa-caret-right"></i> Pelo menos 1 letra minúscula</small></li>
                            <li><small><i class="fas fa-caret-right"></i> Pelo menos 1 letra maiúscula</small></li>
                            <li><small><i class="fas fa-caret-right"></i> Pelo menos 1 caractere especial</small></li>
                        </ul>
                    <label for="senha">Senha</label>
                </div>
            </div>
        
            <div class="md-form">
                <i class="fas fa-unlock prefix"></i>
                <input type="password" name="senha-rep" class="form-control" placeholder="Repita a senha" id="input-senha-rep-cadastro" required>
                <label for="senha-rep">Repita a senha</label>
            </div>
            
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" name="submit" class="btn btn-cyan btn-block">cadastrar</button>
            </div>
        </div>
    
    </div>

</form>


<?php
    include $_SERVER['DOCUMENT_ROOT'].'/rodape.php';
?>

<script type="text/javascript" src="js/awesomplete.js"></script>
<script type="text/javascript" src="js/realtime-validation.js"></script>
<script>

    /* ==============================================================================================================
    ====================================== FUNÇÕES DE FORMATAÇÃO DO FORM DE CADASTRO ================================
    ============================================================================================================== */


    $("#form-cadastro").ready(function() {
        
        $("#input-cpf").mask('000.000.000-00');             /* Formata o CPF */
        $("#input-cep").mask('00000-000');                  /* Formata o CEP */
        $('#input-telefone').mask('(00) 00000-0000');       /* Formata o telefone */
        $('#input-telefone-res').mask('(00) 0000-0000');       /* Formata o residencial */

        // // Buga com icones
        // new Awesomplete('input[type="email"]', {
        //     list: ["terra.com.br", "gmail.com", "hotmail.com", "yahoo.com", "outlook.com"],
        //     data: function (text, input) {
        //         return input.slice(0, input.indexOf("@")) + "@" + text;
        //     },
        //     filter: Awesomplete.FILTER_STARTSWITH
        // });

    });

</script>