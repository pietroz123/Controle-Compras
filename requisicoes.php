<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
?>

<?php
    verifica_usuario();
    mostra_alerta("success");
    mostra_alerta("danger");

    $usuarios_temp = listar($conexao, 
        "SELECT u.ID AS ID_Usuario, c.Nome, u.Usuario, u.Email, u.Criado_Em
        FROM usuarios AS u
        JOIN compradores AS c
        ON u.Email = c.Email
        WHERE u.autenticado = 0;");

    if (count($usuarios_temp) > 0) {
?>

<table class="table table-hover" id="tabela-requisicoes" style="width: 110%; margin-left: -35px;">
    <thead class="thead-dark">
        <th class="t-nome-usuario">Nome</th>
        <th class="t-sobrenome-usuario">Criado Em</th>
        <th class="t-username-usuario">Usuário</th>
        <th class="t-email-usuario">E-mail</th>
        <th class="t-adicionar-usuario">Adicionar</th>
    </thead>

    <tbody>
    <?php    
        foreach ($usuarios_temp as $usuario_temp) {
    ?>
        <tr>
            <td class="t-nome-usuario"><?= $usuario_temp['Nome'] ?></td>
            <td class="t-sobrenome-usuario"><?= $usuario_temp['Criado_Em'] ?></td>
            <td class="t-username-usuario"><?= $usuario_temp['Usuario'] ?></td>
            <td class="t-email-usuario"><?= $usuario_temp['Email'] ?></td>
            <td class="t-adicionar-usuario">
                <form action="scripts/adiciona-usuario-temp.php" method="post">
                    <input type="hidden" name="id" value="<?= $usuario_temp['ID_Usuario'] ?>">
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
    }
    else {
?>
        <div class="alert alert-info" role="alert">Não existem requisições no momento.</div>
<?php
    }
?>

<?php
    include $_SERVER['DOCUMENT_ROOT'].'/rodape.php';
?>