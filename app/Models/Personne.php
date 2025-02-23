<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personne extends Model
{
   protected $fillable=['nom', 'prenom','tel','email','user_id'] ;
   
   protected $with=['user' ];//

   public function fonctions() {
    return $this->belongsToMany(Fonction::class, 'personne_fonctions_projets','personne_id', 'projet_id');
   }

   
   public function projets() {
    return $this->belongsToMany(Projet::class, 'personne_fonction_projets', 'personne_id', 'projet_id');
}
   public function user() {
      return $this->belongsTo(User::class);
  }
  public function actif_fonctions($projet_id) {
    return $this->belongsToMany(Fonction::class, 'personne_fonction_projets')
        ->wherePivot('actif', true)
        ->wherePivot('projet_id', $projet_id);
}


 /* public function taches()
  {
      return $this->hasMany(Tache::class);
  }*/

  public function taches() {
    return $this->belongsToMany(Projet::class, 'personne_projet_taches', 'personne_id', 'projet_id','tache_id');
}
}


