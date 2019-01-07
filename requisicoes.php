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


<table class="table table-hover" style="width: 110%; margin-left: -50px;">
    <thead class="thead-dark">
        <th>Nome</th>
        <th>Sobrenome</th>
        <th>Usuario</th>
        <th>E-mail</th>
        <th>Adicionar</th>
    </thead>

    <tbody>
    <?php
        $usuarios_temp = listar($conexao, "SELECT * FROM usuarios_temp;");
        foreach ($usuarios_temp as $usuario_temp) {
    ?>
        <tr>
            <td><?= $usuario_temp['Primeiro_Nome'] ?></td>
            <td><?= $usuario_temp['Sobrenome'] ?></td>
            <td><?= $usuario_temp['Usuario'] ?></td>
            <td><?= $usuario_temp['Email'] ?></td>
            <td>
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