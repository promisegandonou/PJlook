@extends('layout.app')

@section('content')

<div class="container-fluid mt-4 px-5">
    <div class="card shadow-lg border-0" style="width: 100%;">
        <div class="card-header bg-primary text-white py-3">
            <ul class="nav nav-tabs card-header-tabs justify-content-center" id="projetTabs">
                <li class="nav-item">
                    <a class="nav-link active custom-tab px-4" id="info-tab" data-toggle="tab" href="#info">
                        <i class="fas fa-info-circle me-2"></i> <strong>Informations Générales</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link custom-tab px-4" id="taches-tab" data-toggle="tab" href="#taches">
                        <i class="fas fa-tasks me-2"></i> <strong>Tâches</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link custom-tab px-4" id="membres-tab" data-toggle="tab" href="#membres">
                        <i class="fas fa-users me-2"></i> <strong>Membres</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link custom-tab px-4" id="fichiers-tab" data-toggle="tab" href="#fichiers">
                        <i class="fas fa-folder me-2"></i> <strong>Fichiers</strong>
                    </a>
                </li>

            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="projetTabsContent">
                <div class="tab-pane fade show active" id="info">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-primary fs-4">
                        <i class="fas fa-chart-line me-2"></i> Statut Actuel :
                        <span class="badge bg-success fs-5">{{ $projet->statutActuel->statut->libelle }}</span>
                    </h5>

@can('manage_project_task', $projet)
                    <button class="btn btn-info mt-3" id="editProjectBtn"
                                data-toggle="modal" data-target="#editProjectModal">
                                <i class="fas fa-edit"></i> Modifier le projet
                            </button>
                            @endcan
                 </div>

                    <div class="tab-pane fade show active" id="info">
                        <!-- Bouton pour modifier le statut du projet -->
                        
                        <div class="tab-pane fade show active" id="info">
                            

                            <div class="row g-4">
                                <!-- Carte Titre -->
                                <div class="col-md-3">
                                    <div class="card border-warning shadow-sm p-3 hover-effect">
                                        <div class="card-body text-center">
                                            <i class="fas fa-tag text-warning fs-2 mb-2"></i>
                                            <h5 class="text-secondary fw-bold">Titre</h5>
                                            <p class="fs-4 text-dark fw-semibold">{{ $projet->titre }}</p>

                                        </div>
                                    </div>
                                </div>

                                <!-- Carte Description -->
                                <div class="col-md-3">
                                    <div class="card border-info shadow-sm p-3 hover-effect">
                                        <div class="card-body text-center">
                                            <i class="fas fa-align-left text-info fs-2 mb-2"></i>
                                            <h5 class="text-secondary fw-bold">Description</h5>
                                            <p class="fs-4 text-dark fw-semibold">{{ $projet->description }}</p>

                                        </div>
                                    </div>
                                </div>

                                <!-- Carte Date de début -->
                                <div class="col-md-3">
                                    <div class="card border-danger shadow-sm p-3 hover-effect">
                                        <div class="card-body text-center">
                                            <i class="fas fa-calendar-alt text-danger fs-2 mb-2"></i>
                                            <h5 class="text-secondary fw-bold">Date de début</h5>
                                            <p class="fs-4 text-dark fw-semibold">{{ $projet->date_debut }}</p>

                                        </div>
                                    </div>
                                </div>

                                <!-- Carte Date de fin prévue -->
                                <div class="col-md-3">
                                    <div class="card border-success shadow-sm p-3 hover-effect">
                                        <div class="card-body text-center">
                                            <i class="fas fa-calendar-check text-success fs-2 mb-2"></i>
                                            <h5 class="text-secondary fw-bold">Date de fin prévue</h5>
                                            <p class="fs-4 text-dark fw-semibold">{{ $projet->date_fin }}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>


                </div>

                <div class="tab-pane fade" id="taches">
                   

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-warning fs-4">
                            <i class="fas fa-list-check me-2"></i> Liste des Tâches
                        </h5>
                        @can('manage_project_task', $projet)

                        <button class="btn btn-success" data-toggle="modal" data-target="#ajouterTacheModal">
                            <i class="fas fa-plus"></i> Ajouter une tâche
                        </button>
                        @endcan
                    </div>

                    <div class="main-card mb-3 card">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="taches-table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Titre</th>
                                        <th>Date de début</th>
                                        <th>Date d'échéance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    @php
                    $borderColors = ['border-primary', 'border-success', 'border-warning', 'border-info', 'border-danger'];
                    @endphp

                    @foreach ($projet->taches as $tache)
                    <h6 class="mt-4 font-weight-bold">{{ $tache->titre }}</h6>
                    <div class="row">
                        @foreach ($tache->fichiers as $fichier)
                        @php $borderColor = $borderColors[$loop->index % count($borderColors)]; @endphp
                        <div class="col-md-4">
                            <div class="card shadow-lg mb-3 border {{ $borderColor }} file-card">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-truncate text-dark">{{ $fichier->nom }}</h6>
                                    <a href="{{ route('fichiers.download', $fichier->id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download"></i> Télécharger
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach




                </div>

                <div class="tab-pane fade" id="fichiers">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <h5 class="card-title text-info fs-4">
                        <i class="fas fa-file-alt me-2"></i> Fichiers du Projet
                    </h5>

                    <form action="{{ route('fichiers.upload', $projet->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" name="fichiers[]" multiple class="form-control mb-3">

                        <!-- Sélection d'une tâche (optionnel) -->
                        <label for="tache_id">Associer à une tâche (optionnel) :</label>
                        <select name="tache_id" id="tache_id" class="form-control">
                            <option value="">Aucune tâche spécifique</option>
                            @foreach($projet->taches as $tache)
                            <option value="{{ $tache->id }}">{{ $tache->titre }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary mt-3">Téléverser</button>
                    </form>


                    <ul class="list-group mt-3">
                        @foreach ($projet->fichiers as $fichier)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('fichiers.download', $fichier->id) }}">{{ $fichier->nom }}</a>
                            <form action="{{ route('fichiers.delete', $fichier->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>


                <div class="tab-pane fade" id="membres">
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="card-title text-success fs-4"><i class="fas fa-user-friends me-2"></i> Membres du Projet</h5>
                    @can('invite_member', $projet)

                    <button class="btn btn-success" data-toggle="modal" data-target="#new-member" invite-btn>
                        <i class="fas fa-plus"></i> Inviter
                    </button>
                    @endcan
                    </div>
                    <ul class="list-group list-group-flush mt-3">
                        @foreach ($projet->membres as $membre)
                        <li class="list-group-item py-3 fs-5 d-flex justify-content-between align-items-center">
    {{ $membre->nom }} {{ $membre->prenom }}
    
    @php
        $fonction = $membre->actif_fonctions($projet->id)->first();
    @endphp

    @if ($fonction)
        <span class="badge bg-primary text-white fs-5 px-3 py-2">{{ $fonction->libelle }}</span>
    @else
        <span class="text-muted">Aucune fonction attribuée</span>
    @endif
</li>

                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('modal')

@include('tache.modal.new')
@include('tache.modal.edit')
@include('projet.modal.edit')


@include('membre.modal.new')

@stop

<!-- Ajout de styles CSS pour rendre les onglets plus visibles -->
<style>
    .custom-tab {
        color: white;
        /* Texte blanc par défaut */
        transition: 0.3s ease-in-out;
        border: 2px solid transparent;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px 8px 0 0;
        font-size: 18px;
        padding: 10px 15px;
    }

    .custom-tab:hover {
        color: #ffc107 !important;
        /* Jaune au survol */
        background: rgba(255, 255, 255, 0.4);
    }

    .custom-tab.active {
        background-color: white !important;
        /* Fond blanc pour l'onglet actif */
        color: black !important;
        /* Texte noir pour une meilleure visibilité */
        font-weight: bold;
        border: 2px solid #007bff;
    }

    .custom-tab.active i {
        color: #ffc107 !important;
        /* Seulement pour l'onglet actif */
    }

    .file-card {
        background: linear-gradient(145deg, #ffffff, #f1f1f1);
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border 0.3s ease;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
        border: 2px solid transparent;
    }

    .file-card:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: 0px 15px 35px rgba(0, 0, 0, 0.3);
        border: 2px solid rgba(0, 123, 255, 0.7);
    }

    /* Bordures colorées pour différencier les cartes */
    .border-primary {
        border-left: 6px solid #007bff !important;
    }

    .border-success {
        border-left: 6px solid #28a745 !important;
    }

    .border-warning {
        border-left: 6px solid #ffc107 !important;
    }

    .border-info {
        border-left: 6px solid #17a2b8 !important;
    }

    .border-danger {
        border-left: 6px solid #dc3545 !important;
    }

    .hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-width: 2px;
    }

    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.25);
    }
</style>
@section('scripts')
<!-- Ajout d'animations pour le changement d'onglets -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var triggerTabList = [].slice.call(document.querySelectorAll('#projetTabs a'));
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl);

            triggerEl.addEventListener('click', function(event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
</script>

<script>


    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#taches-table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/fr_fr.json'
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('taches_datatable', ['id' => $projet->id]) }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'titre',
                    name: 'titre'
                },
                {
                    data: 'date_debut',
                    name: 'date_debut'
                },
                {
                    data: 'date_echeance',
                    name: 'date_echeance'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // MODIFIER une tâche
        $(document).on('click', '.btn-edit', function() {
            let taskId = $(this).data('id');
            $.get('/taches/' + taskId + '/edit')
                .done(function(data) {
                    $('#editModal').modal('show');
                    $('#editForm').attr('action', '/taches/' + taskId);
                    $('#editTitre').val(data.titre);
                    $('#editDescription').val(data.description);
                    $('#editDateDebut').val(data.date_debut);
                    $('#editDateEcheance').val(data.date_echeance);
                })
                .fail(function() {
                    alert("Erreur lors du chargement des données.");
                });
        });

        $(document).on('submit', '#editForm', function(e) {
            e.preventDefault(); // Empêche le rechargement de la page

            let formData = $(this).serialize(); // Sérialise les données du formulaire
            let actionUrl = $(this).attr('action'); // Récupère l'URL de soumission

            $.ajax({
                url: actionUrl,
                type: 'POST', // Laravel n'accepte pas PUT en AJAX sans _method
                data: formData + '&_method=PUT', // Ajoute _method=PUT dans les données
                success: function(response) {
                    alert("Tâche mise à jour avec succès !");
                    $('#editModal').modal('hide'); // Fermer le modal
                    location.reload(); // Recharger la page
                },
                error: function(xhr) {
                    alert("Erreur lors de la mise à jour de la tâche !");
                    console.log(xhr.responseText); // Affiche l'erreur dans la console
                }
            });
        });



        // SUPPRIMER une tâche
    $(document).on('click', '.btn-delete', function () {
        let taskId = $(this).data('id');
        if (confirm("Voulez-vous vraiment supprimer cette tâche ?")) {
            $.ajax({
                url: '/taches/' + taskId, 
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // Protection CSRF
                },
                success: function (response) {
                    alert(response.message);
                    $('#dataTable').DataTable().ajax.reload(); // Recharge le tableau
                },
                error: function (xhr) {
                    alert("Une erreur s'est produite !");
                }
            });
        }
    });




        // AFFICHER une tâche
        $(document).on('click', '.btn-view', function() {
            let taskId = $(this).data('id');
            $.get('/taches/' + taskId)
                .done(function(data) {
                    $('#viewModal').modal('show');
                    $('#viewTitre').text(data.titre);
                    $('#viewStatut').text(data.statut ? data.statut.libelle : 'Non défini');
                    $('#viewDateDebut').text(data.date_debut);
                    $('#viewDateEcheance').text(data.date_echeance);
                })
                .fail(function() {
                    alert("Erreur lors du chargement des données.");
                });
        });
    });

   

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Script chargé !"); // Vérifie si le script est exécuté

        let editForm = document.getElementById("editProjectForm");
        if (!editForm) {
            console.error("Formulaire non trouvé !");
            return;
        }

        editForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Empêche le rechargement de la page

            console.log("Formulaire soumis !"); // Vérifie si l'événement fonctionne

            let projetId = document.getElementById("editProjectId").value;
            let formData = new FormData(editForm);
            formData.append("_method", "PUT");

            fetch("{{ route('projet.update', ':id') }}".replace(':id', projetId), {
                method: "POST",
              
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("Réponse du serveur :", data);
                if (data.success) {
                    alert("Projet mis à jour !");
                    location.reload(); // Recharge la page pour voir les changements
                } else {
                    alert("Erreur lors de la mise à jour.");
                }
            })
            .catch(error => console.error("Erreur :", error));
        });
    });
</script>






@stop