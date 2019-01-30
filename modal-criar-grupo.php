<div class="modal" id="modal-criar-grupo">
    <div class="modal-dialog" id="criar-grupo">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Criação de Grupo</h3>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form name="adicionar-username" id="adicionar-username" action="scripts/adicionar-grupo.php" method="post">
                    <div class="grid">
                        <div class="row">
                            <div class="col-sm-4">Nome:</div>
                            <div class="col-sm-8"><input type="text" name="nome-grupo" class="form-control" placeholder="Nome do grupo"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <select class="form-control input-usuario" name="usernames[]" multiple="multiple">
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="submit-criar-grupo" id="submit-criar-grupo" class="btn btn-blue">Criar grupo</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>    