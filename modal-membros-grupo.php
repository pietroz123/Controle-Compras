<?php
    if (isset($_POST['id_grupo'])) {
        $id_grupo = $_POST['id_grupo'];
?>
        
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="titulo-membros">Família</h3>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-hover">
                <thead>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Membro desde</th>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fas fa-user"></i></td>
                        <td>Pietro</td>
                        <td>AAAA-DD-MM</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-user"></i></td>
                        <td>Bianca</td>
                        <td>AAAA-DD-MM</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            
        </div>
    </div>

<?php
    }