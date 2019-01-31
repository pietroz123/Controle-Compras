<div class="modal" id="modal-criar-grupo">
    <div class="modal-dialog" id="criar-grupo">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Criação de Grupo</h3>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form name="adicionar-username" id="adicionar-username" action="scripts/adicionar-grupo.php" method="post">
                <div class="modal-body">
                    <div class="grid">
                        <div class="row">
                            <div class="col-sm-4" style="font-weight: bold;">Nome:</div>
                            <div class="col-sm-8"><input type="text" name="nome-grupo" class="form-control" placeholder="Nome do grupo"></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm" style="font-weight: bold;">Usuários:</div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm">
                                <select class="form-control input-usuario" name="usernames[]" multiple="multiple" style="width: 100%;">

                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit-criar-grupo" id="submit-criar-grupo" class="btn btn-blue">Criar grupo</button>
                </div>
            </form>
        </div>
    </div>
</div>    