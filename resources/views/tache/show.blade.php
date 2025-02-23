@extends('layout.app')

@section('content')
<div class="container-fluid mt-4 px-5"> <!-- Utilisation de container-fluid pour occuper toute la largeur -->
    <div class="row justify-content-center">
        <div class="col-lg-10"> <!-- Réduction de la largeur pour un meilleur centrage -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">{{ $tache->titre }}</h2>
                </div>
                <div class="card-body">
                    <div class="row mb-3"> <!-- Disposition en deux colonnes -->
                        <div class="col-md-6">
                            <p class="fs-6"><i class="fas fa-tasks text-primary"></i> <strong>Statut :</strong> {{ $tache->statut ? $tache->statut->libelle : 'Non défini' }}</p>
                            <p class="fs-6"><i class="fas fa-user text-success"></i> <strong>Assignée à :</strong> {{ $tache->personne ? $tache->personne->nom .' '.$tache->personne->prenom : 'Non assigné' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="fs-6"><i class="far fa-calendar-alt text-warning"></i> <strong>Début :</strong> {{ $tache->date_debut ? \Carbon\Carbon::parse($tache->date_debut)->format('d/m/Y') : 'Non assignée' }}</p>
                            <p class="fs-6"><i class="fas fa-hourglass-end text-danger"></i> <strong>Échéance :</strong> {{ $tache->date_echeance ? \Carbon\Carbon::parse($tache->date_echeance)->format('d/m/Y') : 'Non assignée' }}</p>
                        </div>
                    </div>
                    <p class="fs-6 text-muted"><i class="fas fa-align-left text-info"></i> <strong>Description :</strong> {{ $tache->description ?? 'Aucune description' }}</p>

                    @if(auth()->user()->personne && auth()->user()->personne->id === $tache->personne_id)
    <div class="mt-4">
        <form action="{{ route('tache.updateStatut', $tache->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="statut" class="form-label fs-6">
                <i class="fas fa-sync-alt text-primary"></i> Modifier le statut :
            </label>
            <div class="input-group">
                <select name="statut_id" id="statut" class="form-control">
                    @foreach ($statuts as $statut)
                        <option value="{{ $statut->id }}" {{ $tache->statut_id == $statut->id ? 'selected' : '' }}>
                            {{ $statut->libelle }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
@endif

                </div>
                <div class="card-footer text-center bg-light">
                    <a href="{{ route('projet.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Retour aux projets</a>
                </div>
            </div>
        </div>
    </div>

    @if ($tache->projet && $tache->projet->taches->count())
        <div class="mt-5">
            <h3 class="text-center text-primary"><i class="fas fa-folder-open"></i> Fichiers des Tâches du Projet</h3>
            <div class="row justify-content-center">
                @foreach ($tache->projet->taches as $tache_projet)
                    <div class="col-12 mt-4">
                        <h4 class="text-dark text-center">{{ $tache_projet->titre }}</h4>
                        <div class="row justify-content-center">
                            @foreach ($tache_projet->fichiers as $fichier)
                                <div class="col-md-3">
                                    <div class="card shadow-sm border-3 file-card border-{{ ['primary', 'success', 'danger', 'warning', 'info'][rand(0, 4)] }}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-truncate text-dark">{{ $fichier->nom }}</h5>
                                            <a href="{{ route('fichiers.download', $fichier->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download"></i> Télécharger
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="mt-4 text-muted text-center"><i class="fas fa-exclamation-circle"></i> Aucune tâche avec des fichiers trouvée.</p>
    @endif
</div>
@stop

<style>
    .file-card:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease-in-out;
    }
</style>
