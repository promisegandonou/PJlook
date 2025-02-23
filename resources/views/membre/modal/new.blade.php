<!-- Modal Inviter un membre -->
<div class="modal fade" id="new-member" tabindex="-1" aria-labelledby="new-membre" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="new-member">Envoyer une invitation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('projet.send.invitation') }}" method="POST">
                    @csrf
                    <input type="hidden" name="projet_id" value="{{ $projet->id }}">

                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre du projet</label>
                        <input type="text" class="form-control" id="titre" name="titre" required value="{{$projet->titre}}">
                    </div>


                    <div class="mb-3">
                        <label for="personne" class="form-label">Personne</label>
                        <select class="form-control" id="membre" name="personne_id">
                            @foreach ($allPersonnes as $personne)
                            <option value="{{ $personne->id }}" data-email="{{ $personne->email }}">
                                {{ $personne->nom }} {{ $personne->prenom }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" readonly>
                    </div>

                    </div>

                    <div class="mb-3">
                        <label for="fonction" class="form-label">Rôle</label>
                        <select class="form-control" id="fonction" name="fonction_id">
                            @foreach ($fonctions as $fonction)
                            <option value="{{ $fonction->id }}" >
                                {{ $fonction->libelle }} 
                            </option>
                            @endforeach
                        </select>
                    </div>




                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Envoyer une invitation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let selectPersonne = document.getElementById("membre");
        let inputEmail = document.getElementById("email");

        selectPersonne.addEventListener("change", function () {
            let selectedOption = selectPersonne.options[selectPersonne.selectedIndex];
            let email = selectedOption.getAttribute("data-email");
            inputEmail.value = email;
        });

        // Définir l'email par défaut lors du chargement de la page
        if (selectPersonne.options.length > 0) {
            let defaultEmail = selectPersonne.options[selectPersonne.selectedIndex].getAttribute("data-email");
            inputEmail.value = defaultEmail;
        }
    });
</script>
