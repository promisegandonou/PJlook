<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonneProjetTache extends Model
{
    protected $fillable=['personne_id','projet_id','tache_id','statut_id','date_debut','date_fin'];
    
    protected $casts= [
        'statut_id',
        'date_debut'=> 'date',
        'date_fin'=> 'date',
        'projet_id'
    ];//

    public function personne() {
        return $this->belongsTo(Personne::class);
    }

    public function tache() {
        return $this->belongsTo(Tache::class);
    }

    public function projet() {
        return $this->belongsTo(Projet::class);
    } //
}
