<?php include("cabecalho.php"); ?>

        <h1>Formulário de Adição de Comprador</h1>
        
        <form action="adiciona-comprador.php">
        
            <table class="table">

                <!-- Nome -->
                <tr>
                    <td>Nome</td>
                    <td><input class="form-control" type="text" name="nome"></td>
                </tr>

                <!-- Cidade -->
                <tr>
                    <td>Cidade</td>
                    <td><input class="form-control" type="text" name="cidade"></td>
                </tr>

                <!-- Estado -->
                <tr>
                    <td>Estado</td>
                    <td><input class="form-control" type="text" name="estado"></td>
                </tr>

                <!-- Endereço -->
                <tr>
                    <td>Endereço</td>
                    <td><input class="form-control" type="text" name="endereco"></td>
                </tr>

                <!-- CEP -->
                <tr>
                    <td>CEP</td>
                    <td><input class="form-control" type="text" name="cep"></td>
                </tr>

                <!-- CPF -->
                <tr>
                    <td>CPF</td>
                    <td><input class="form-control" type="text" name="cpf"></td>
                </tr>

                <!-- Email -->
                <tr>
                    <td>E-mail</td>
                    <td><input class="form-control" type="email" name="email"></td>
                </tr>

                <!-- Telefone -->
                <tr>
                    <td>Telefone</td>
                    <td><input class="form-control" type="tel" name="telefone"></td>
                </tr>

                <!-- SUBMIT -->
                <tr>
                    <td>
                        <button class="btn btn-primary" type="submit">Adicionar</button><br>
                    </td>
                </tr>

            </table>

        </form>


<?php include("rodape.php"); ?>