<!-- Modal Ajouter Tâche -->
<div class="modal fade" id="ajouterTacheModal" tabindex="-1" aria-labelledby="ajouterTacheLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterTacheLabel">Ajouter une nouvelle tâche</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tache.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="projet_id" value="{{ $projet->id }}">

                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre de la tâche</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">description de la tâche</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="personne" class="form-label">Assigner la tâche à</label>
                        <select class="form-control" id="personne" name="personne_id">
                            <option value="">Sélectionner une personne</option> <!-- Option vide -->
                            @foreach ($personnes as $personne)
                            <option value="{{ $personne->id }}">{{ $personne->nom }} {{ $personne->prenom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date de début et échéance (masqués par défaut) -->
                    <div id="dates-container" style="display: none;">
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut">
                        </div>

                        <div class="mb-3">
                            <label for="date_echeance" class="form-label">Date d'échéance</label>
                            <input type="date" class="form-control" id="date_echeance" name="date_echeance">
                        </div>

                        <div class="mb-3">
                        <label for="statut" class="form-label">Statut</label>
                        <select class="form-control" id="statut" name="statut_id">
                            @foreach ($statuts as $statut)
                            <option value="{{ $statut->id }}">{{ $statut->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                   

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let selectPersonne = document.getElementById("personne");
    let datesContainer = document.getElementById("dates-container");

    selectPersonne.addEventListener("change", function() {
        if (this.value) {
            datesContainer.style.display = "block"; // Affiche les champs si une personne est sélectionnée
        } else {
            datesContainer.style.display = "none"; // Cache les champs si aucune personne n'est choisie
        }
    });
});
</script>
