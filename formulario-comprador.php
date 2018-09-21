<?php include("cabecalho.php"); ?>

        <h1>Formulário de Adição de Comprador</h1>
        
        <form action="adiciona-comprador.php">
        
            <!-- Nome -->
            <div class="caixa-adicao">
                <label>Nome</label>:<br>
                    <input type="text" name="nome"><br>
            </div>
            
            <!-- Cidade -->
            <div class="caixa-adicao">
                <label>Cidade</label>:<br>
                    <input type="text" name="cidade"><br>
            </div>

            <!-- Estado -->
            <div class="caixa-adicao">
                <label>Estado</label>:<br>
                    <input type="text" name="estado"><br>
            </div>

            <!-- Endereço -->
            <div class="caixa-adicao">
                <label>Endereço</label> (formato: Rua/Av Nome, Número):<br>
                    <input type="text" name="endereco"><br>
            </div>

            <!-- CEP -->
            <div class="caixa-adicao">
                <label>CEP:</label>:<br>
                    <input type="text" name="cep"><br>
            </div>

            <!-- CPF -->
            <div class="caixa-adicao">
                <label>CPF</label>:<br>
                    <input type="text" name="cpf"><br>
            </div>

            <!-- Email -->
            <div class="caixa-adicao">
                <label>E-mail:</label>:<br>
                    <input type="email" name="email"><br>
            </div>

            <!-- Telefone -->
            <div class="caixa-adicao">
                <label>Telefone</label>:<br>
                    <input type="tel" name="telefone"><br>
            </div>

            <!-- SUBMIT -->
            <div class="caixa-adicao">
                <input type="submit" value="Adicionar"><br>
            </div>

        </form>


<?php include("rodape.php"); ?>