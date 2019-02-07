<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/cabecalho.php'; 
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-usuarios.php';
    include $_SERVER['DOCUMENT_ROOT'].'/includes/funcoes-grupos.php';
?>

<?php
    verifica_usuario();
    mostra_alerta("success");
    mostra_alerta("danger");

    // // Recupera todas as informações do usuário
    // $comprador_usuario = join_usuario_comprador($conexao, $_SESSION['login-email']);
    
    // Recupera todos os grupos do usuário
    $grupos = recuperar_grupos($conexao, $_SESSION['login-username']);
    
    // // Recupera todos os IDs dos compradores em todos os grupos do usuário
    // $ids_compradores = recupera_ids_compradores_grupos($conexao, $_SESSION['login-username'], $_SESSION['login-email']);

    // // Recupera as compras que o usuário pode visualizar
    // $compras_permitidas = compras_permitidas($conexao, $_SESSION['login-username'], $_SESSION['login-email']);

?>

<h1 style="text-align: left;">Grupos</h1>
<div class="mensagem-alerta">
    <div>Selecione as compras que deseja visualizar:</div>
</div>


<div class="cartao-novo">
    <a role="button" class="link-cartao-minhas-compras" id-comprador="<?= $_SESSION['login-id-comprador']; ?>">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 col-md-4 col-lg-3 col-xl-2 cg-coluna-imagem pink darken-4">
                    <img src="img/usuario.png" alt="Imagem perfil" class="rounded-circle white cg-imagem">
                </div>
                <div class="col-sm-10 col-md col-lg col-xl cg-coluna-informacoes">
                    <div class="row cg-linha-nome">
                        <div class="col-sm">
                            <div class="cg-nome">Minhas Compras</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm"><?= $_SESSION['login-nome']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>


<hr>

<div class="cartoes">
<?php
    $i = 0;
    foreach ($grupos as $grupo) {
        $i++;
?>
    <div class="cartao-novo">
        <a role="button" class="link-cartao-grupo" id-grupo="<?= $grupo['ID']; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2 col-md-4 col-lg-3 col-xl-2 cg-coluna-imagem indigo">
                        <img src="img/grupo.png" alt="Imagem perfil" class="rounded-circle white cg-imagem">
                    </div>
                    <div class="col-sm-10 col-md col-lg col-xl cg-coluna-informacoes">
                        <div class="row cg-linha-nome">
                            <div class="col-sm-12">
                                <div class="cg-nome"><?= $grupo['Nome']; ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-10 col-lg-8 small-bold">Data de criação</div>
                            <div class="col-sm-6 col-md col-lg small-faded"><?= date("d/m/Y", strtotime($grupo['Data_Criacao'])); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-10 col-lg-8 small-bold">Número de membros</div>
                            <div class="col-sm-6 col-md col-lg small-faded"><?= $grupo['Numero_Membros']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php
    }    
    if ($i == 0) {
?>
        <div class="alert alert-info">Você não está em nenhum grupo, logo apenas poderá ver suas compras</div>
<?php
    }
?>
</div>

<hr>
<h1 style="margin-top: 40px;">Lista de Compras</h1>

<!-- Tabela com as compras -->
<table class="table table-hover" id="tabela-compras" style="width: 110%; margin-left: -50px;">

    <thead class="thead-dark">
        <tr>
            <th class="th-sm t-id">ID</th>
            <th class="th-sm t-data">Data</th>
            <th class="th-sm t-observacoes">Observacoes</th>
            <th class="th-sm t-valor">Valor</th>
            <th class="th-sm t-desconto">Desconto</th>
            <th class="th-sm t-pagamento">Pagamento</th>
            <th class="th-sm t-comprador">Comprador</th>
            <th class="t-imagem">Imagem</th>
            <th class="th-sm t-alterar">Alterar</th>
            <th class="th-sm t-remover">Remover</th>
            <th class="th-sm t-detalhes">Detalhes</th> 
        </tr>
    </thead>

    <tbody id="compras-datatable">
    <?php
        $compras = recuperar_compras($conexao, $_SESSION['login-id-comprador']);
        foreach ($compras as $compra) :
    ?>

        <tr>
            <td class="t-id"><?= $compra['Id']; ?></td>
            <td class="t-data"><?= $compra['Data']; ?></td>
            <td class="t-observacoes"><?= $compra['Observacoes']; ?></td>
            <td class="t-valor"><?= $compra['Valor']; ?></td>
            <td class="t-desconto"><?= $compra['Desconto']; ?></td>          
            <td class="t-pagamento"><?= $compra['Forma_Pagamento']; ?></td>
            <td class="t-comprador"><?= $compra['Nome_Comprador']; ?></td>
            <td class="t-imagem">
                <button type="button" class="btn light-blue btn-block botao-pequeno btn-imagem" id="<?= $compra['Id']; ?>">imagem</button>
            </td>
            <td class="t-alterar">
                <form action="formulario-alterar-compra.php" method="post">
                    <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
                    <button class="btn btn-primary botao-pequeno">alterar</button>
                </form>
            </td>
            <td class="t-remover">
                <form action="scripts/remover-compra.php" method="post">
                    <input type="hidden" name="id" value="<?= $compra['Id'] ?>">
                    <button class="btn btn-danger botao-pequeno" onclick="return confirm('Deseja prosseguir com a remoção?');">remover</button>
                </form>
            </td>
            <td class="t-detalhes">
                <button type="button" id="<?= $compra['Id']; ?>" class="btn btn-info botao-pequeno btn-detalhes">detalhes</button>
            </td>
        </tr>

    <?php
        endforeach
    ?>

    </tbody>

    <tfoot>
        <tr>
            <th class="t-id">ID</th>
            <th class="t-data">Data</th>
            <th class="t-observacoes">Observacoes</th>
            <th class="t-valor">Valor</th>
            <th class="t-desconto">Desconto</th>
            <th class="t-pagamento">Pagamento</th>
            <th class="t-comprador">Comprador</th>
            <th class="t-imagem">Imagem</th>
            <th class="t-alterar">Alterar</th>
            <th class="t-remover">Remover</th>
            <th class="t-detalhes">Detalhes</th>            
        </tr>
    </tfoot>

</table>

<!-- Modal para detalhes da Compra -->
<div class="modal" id="modal-detalhes-compra">
    <div class="modal-dialog" id="detalhes-compra">
        <!-- Preenchido com AJAX (JS) -->
    </div>
</div>

<!-- Modal para imagem da Compra -->
<div class="modal" id="modal-imagem-compra">
    <div class="modal-dialog" id="imagem-compra">
        <!-- Preenchido com AJAX (JS) -->        
    </div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'].'/rodape.php'; ?>

<script>

    // Inicializa a tabela de dados
    $(document).ready(function () {

        // $(window).resize(function() {
        //     if ($(window).width() <= 660) {
        //         $('.cartao-novo').css({
        //             'width': '100%'
        //         });
        //     } else {
        //         $('.cartao-novo').css({
        //             'width': '50%'
        //         });
        //     }
        // });

        $('#tabela-compras').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ itens por página",
                "zeroRecords": "Nenhum item encontrado - desculpa",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum item encontrado",
                "infoFiltered": "(filtrado a partir de _MAX_ itens)",
                "search": "Buscar:",
                "emptyTable":     "Nenhum dado disponível na tabela",
                "loadingRecords": "Carregando...",
                "processing":     "Processando...",
                "paginate": {
                    "first":      "Primeiro",
                    "last":       "Último",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                }
            }
        });
        $('.dataTables_length').addClass('bs-select');
    });

    // Preenche o modal-detalhes-compra utilizando AJAX
    $(document).on('click', '.btn-detalhes', function() {
        var id_compra = $(this).attr("id");        

        $.ajax({
            url: "modal-detalhes-produto.php",
            method: "post",
            data: {
                id_compra: id_compra
            },
            success: function(data) {
                $("#detalhes-compra").html(data);
                $("#modal-detalhes-compra").modal("show");
            }
        });
    });

    // Modal para a imagem da compra
    $(document).on('click', '.btn-imagem', function() {
        var id_compra = $(this).attr("id");   

        $.ajax({
            url: "modal-imagem-compra.php",
            method: "post",
            data: {
                id_compra: id_compra
            },
            success: function(data) {
                $("#imagem-compra").html(data);
                $("#modal-imagem-compra").modal("show");
            }
        });
    });


    //! Outra forma de preencher o modal:
    //? Antes era: 
    //*     <button class="btn btn-info botao-pequeno" data-toggle="modal" data-target="#modal-detalhes-compra" data-id="<?= $compra['Id']; ?>" data-data="<?= $compra['Data']; ?>" data-observacoes="<?= $compra['Observacoes']; ?>" data-valor="<?= $compra['Valor']; ?>" data-desconto="<?= $compra['Desconto']; ?>" data-pagamento="<?= $compra['Forma_Pagamento']; ?>" data-comprador="<?= $compra['Nome_Comprador']; ?>">detalhes</button>
    // // Coloca as informacoes no modal (javascript com AJAX)
    // $('#modal-detalhes-compra').on('show.bs.modal', function(event) {
    //     // Recupera as informacoes do botao
    //     var botao = $(event.relatedTarget);
    //     var id = botao.data('id');
    //     var data = botao.data('data');
    //     var observacoes = botao.data('observacoes');
    //     var valor = botao.data('valor');
    //     var desconto = botao.data('desconto');
    //     var pagamento = botao.data('pagamento');
    //     var comprador = botao.data('comprador');
        
    //     // Imprime nos campos do modal-detalhes-compra
    //     var modal = $(this);
    //     modal.find('#id-compra').val(id);
    //     modal.find("#data-compra").val(data);
    //     modal.find("#observacoes-compra").val(observacoes);
    //     modal.find("#valor-compra").val(valor);
    //     modal.find("#desconto-compra").val(desconto);
    //     modal.find("#pagamento-compra").val(pagamento);
    //     modal.find("#comprador-compra").val(comprador);
    // });


    // ======================================================================================================================================
    // ==================================== AO CLICAR EM UM GRUPO, RECUPERA AS COMPRAS DAQUELE GRUPO ========================================
    // ======================================================================================================================================

    $('.link-cartao-grupo').click(function () {
        var id_grupo = $(this).attr('id-grupo');

        $.ajax({
            url: "scripts/recuperar-compras.php",
            method: "post",
            data: {
                id_grupo: id_grupo
            },
            success: function(retorno) {

                // Limpa e destrói a tabela
                $("#tabela-compras").DataTable().clear().destroy();

                // Preenche a tabela com as compras do grupo
                $('#compras-datatable').html(retorno);
                
                // Reinicializa a datatable
                $('#tabela-compras').DataTable({
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ itens por página",
                        "zeroRecords": "Nenhum item encontrado - desculpa",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "Nenhum item encontrado",
                        "infoFiltered": "(filtrado a partir de _MAX_ itens)",
                        "search": "Buscar:",
                        "emptyTable":     "Nenhum dado disponível na tabela",
                        "loadingRecords": "Carregando...",
                        "processing":     "Processando...",
                        "paginate": {
                            "first":      "Primeiro",
                            "last":       "Último",
                            "next":       "Próximo",
                            "previous":   "Anterior"
                        }
                    }
                });
                $('.dataTables_length').addClass('bs-select');

                // Scroll até a tabela de compras
                $('html, body').animate({
                    scrollTop: $('#tabela-compras').offset().top - 120
                }, 1000);
            }
        });
        
    });


    // ======================================================================================================================================
    // ================================== AO CLICAR EM MINHAS COMPRAS, RECUPERA AS COMPRAS DAQUELE COMPRADOR ================================
    // ======================================================================================================================================

    $('.link-cartao-minhas-compras').click(function () {
        var id_comprador = $(this).attr('id-comprador');

        $.ajax({
            url: "scripts/recuperar-compras.php",
            method: "post",
            data: {
                id_comprador: id_comprador
            },
            success: function(retorno) {                

                // Limpa e destrói a tabela
                $("#tabela-compras").DataTable().clear().destroy();

                // Preenche a tabela com as compras do grupo
                $('#compras-datatable').html(retorno);
                
                // Reinicializa a datatable
                $('#tabela-compras').DataTable({
                    "language": {
                        "lengthMenu": "Mostrar _MENU_ itens por página",
                        "zeroRecords": "Nenhum item encontrado - desculpa",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "Nenhum item encontrado",
                        "infoFiltered": "(filtrado a partir de _MAX_ itens)",
                        "search": "Buscar:",
                        "emptyTable":     "Nenhum dado disponível na tabela",
                        "loadingRecords": "Carregando...",
                        "processing":     "Processando...",
                        "paginate": {
                            "first":      "Primeiro",
                            "last":       "Último",
                            "next":       "Próximo",
                            "previous":   "Anterior"
                        }
                    }
                });
                $('.dataTables_length').addClass('bs-select');

                // Scroll até a tabela de compras
                $('html, body').animate({
                    scrollTop: $('#tabela-compras').offset().top - 120
                }, 1000);
            }
        });
        
    });




</script>