<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonneFonctionProjet extends Model
{
    
    protected $fillable=['personne_id','fonction_id','projet_id','actif','date_debut','date_fin'];
    
    protected $casts= [
        'actif'=> 'boolean',
        'date_debut'=> 'date',
        'date_fin'=> 'date',
        'projet_id'
    ];//

    public function personne() {
        return $this->belongsTo(Personne::class);
    }

    public function fonction() {
        return $this->belongsTo(Fonction::class);
    }

    public function projet() {
        return $this->belongsTo(Projet::class);
    }
}
