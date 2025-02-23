<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    Protected $fillable=['titre','description','date_debut','date_echeance','personne_id','projet_id','statut_id'];//

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function personne()
    {
        return $this->belongsTo(Personne::class, 'personne_id');
    }

    public function statut()
    {
        return $this->belongsTo(Statut::class);
    }

    public function fichiers()
    {
        return $this->hasMany(Fichier::class);
    }



    
}
