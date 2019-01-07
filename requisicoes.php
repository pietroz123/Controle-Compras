<?php
    include("cabecalho.php");
    include("database/conexao.php");
    include("funcoes.php");
?>

<?php
    verifica_usuario();
    mostra_alerta("success");
    mostra_alerta("danger");
?>


<table class="table table-hover" id="tabela-requisicoes" style="width: 110%; margin-left: -35px;">
    <thead class="thead-dark">
        <th class="t-nome-usuario">Nome</th>
        <th class="t-sobrenome-usuario">Sobrenome</th>
        <th class="t-username-usuario">Usuario</th>
        <th class="t-email-usuario">E-mail</th>
        <th class="t-adicionar-usuario">Adicionar</th>
    </thead>

    <tbody>
    <?php
        $usuarios_temp = listar($conexao, "SELECT * FROM usuarios_temp;");
        foreach ($usuarios_temp as $usuario_temp) {
    ?>
        <tr>
            <td class="t-nome-usuario"><?= $usuario_temp['Primeiro_Nome'] ?></td>
            <td class="t-sobrenome-usuario"><?= $usuario_temp['Sobrenome'] ?></td>
            <td class="t-username-usuario"><?= $usuario_temp['Usuario'] ?></td>
            <td class="t-email-usuario"><?= $usuario_temp['Email'] ?></td>
            <td class="t-adicionar-usuario">
                <form action="adiciona-usuario-temp.php" method="post">
                    <input type="hidden" name="id" value="<?= $usuario_temp['ID'] ?>">
                    <button class="btn btn-primary botao-pequeno">adicionar</button>
                </form>
            </td>
        </tr>
    <?php
        }
    ?>
    
    </tbody>
</table>

<?php
    include("rodape.php");
?>