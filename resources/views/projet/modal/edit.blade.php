<!-- Modale de modification -->
<div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectModalLabel">Modifier le projet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProjectForm">
                    @csrf
                    <input type="hidden" id="editProjectId" name="id" value="{{ $projet->id }}">
                    <input type="hidden" name="_method" value="PUT"> <!-- Simule PUT -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="mb-3">
                        <label for="editTitre" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="editTitre" name="titre" value="{{ $projet->titre }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3" required>{{ $projet->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="editDateDebut" class="form-label">Date de début</label>
                        <input type="date" class="form-control" id="editDateDebut" name="date_debut" value="{{ $projet->date_debut }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="editDateFin" class="form-label">Date de fin prévue</label>
                        <input type="date" class="form-control" id="editDateFin" name="date_fin" value="{{ $projet->date_fin }}" required>
                    </div>
                    <div class="mb-3">
                    <label for="editStatut" class="form-label">Statut</label>

                    <select name="statut_id" id="editStatut"  class="form-control">
                                    @foreach ($statuts as $statut)
                                        <option class="form-control"  value="{{ $statut->id }}" {{ $projet->statut_id == $statut->id ? 'selected' : '' }} > 
                                            {{ $statut->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>