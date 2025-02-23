<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
    protected $fillable = ['nom', 'prenom', 'tel', 'email', 'user_id'];

    protected $with = ['user'];

    // Relation avec les fonctions via la table pivot personne_fonction_projets
    public function fonctions()
    {
        return $this->belongsToMany(Fonction::class, 'personne_fonction_projets', 'personne_id', 'fonction_id')
            ->withPivot('projet_id', 'actif', 'date_debut', 'date_fin');
    }

    // Relation avec les projets via la table pivot personne_fonction_projets
    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'personne_fonction_projets', 'personne_id', 'projet_id')
            ->withPivot('fonction_id', 'actif', 'date_debut', 'date_fin');
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Obtenir les fonctions actives d'une personne sur un projet donné
    public function actif_fonctions($projet_id)
    {
        return $this->belongsToMany(Fonction::class, 'personne_fonction_projets', 'personne_id', 'fonction_id')
            ->wherePivot('actif', true)
            ->wherePivot('projet_id', $projet_id);
    }

    // Relation avec les tâches via la table pivot personne_projet_taches
    public function taches()
    {
        return $this->belongsToMany(Tache::class,  'personne_id', 'tache_id')
           ;
    }

    // Méthodes pour les statistiques

    public function nombreProjets() {
        return $this->projets()->select('projets.id as projet_id')->count();
    }
    

    public function nombreTaches()
{
    return $this->taches()->count();
}


    public function nombrePersonnesSurProjets()
    {
        return Personne::whereHas('projets', function ($query) {
            $query->whereIn('projets.id', $this->projets()->pluck('projets.id'));
        })->count();
    }
}
