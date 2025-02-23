<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projet extends Model
{
    Protected $fillable=['titre','description','date_debut', 'date_fin'];//

    public function statuts()
    {
        return $this->hasMany(ProjetStatut::class);
    }

    public function statutActuel()
{
    return $this->hasOne(ProjetStatut::class)->where('actif', true);
}


    // Relation avec les tâches
    

    // Relation avec les membres via la table pivot personne_fonction_projets
    public function membres(): BelongsToMany
    {
        return $this->belongsToMany(Personne::class, 'personne_fonction_projets', 'projet_id', 'personne_id')->withPivot('fonction_id');
    }
    public function taches(): HasMany
    {
        return $this->hasMany(Tache::class);
    }
    ///
    public function PersonneTaches(): BelongsToMany
    {
        return $this->belongsToMany(Personne::class, 'personne_projet_taches', 'projet_id', 'personne_id','tache_id');
    }

    public function fichiers()
    {
        return $this->hasMany(Fichier::class);
    }
}
