<?php
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
?>

<?php
    verifica_usuario();
    mostra_alerta("success");
    mostra_alerta("danger");

    $usuarios_temp = recuperar_usuarios_temp($conexao);

    if (count($usuarios_temp) > 0) {
?>

<table class="table table-hover table-sm" id="tabela-requisicoes">
    <thead class="thead-dark">
        <th class="t-nome-usuario">Nome</th>
        <th class="t-sobrenome-usuario">Criado Em</th>
        <th class="t-username-usuario">Usuário</th>
        <th class="t-email-usuario">E-mail</th>
        <th class="t-adicionar-usuario">Adicionar</th>
        <th class="t-rejeitar-usuario">Rejeitar</th>
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
            <td class="t-rejeitar-usuario">
                <form action="scripts/rejeitar-usuario-temp.php" method="post">
                    <input type="hidden" name="email" value="<?= $usuario_temp['Email'] ?>">
                    <button class="btn btn-danger botao-pequeno">rejeitar</button>
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