<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la tâche</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Titre</label>
                        <input type="text" class="form-control" id="editTitre" name="titre">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" id="editDescription" name="description">
                    </div>
                    <div class="form-group">
                        <label>Date début</label>
                        <input type="date" class="form-control" id="editDateDebut" name="date_debut">
                    </div>
                    <div class="form-group">
                        <label>Date d'échéance</label>
                        <input type="date" class="form-control" id="editDateEcheance" name="date_echeance">
                    </div>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
