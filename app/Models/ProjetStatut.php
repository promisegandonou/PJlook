<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjetStatut extends Model
{
    protected $fillable=['projet_id','statut_id','actif','date_debut','date_fin'];
    
    protected $casts= [
        'actif'=> 'boolean',
        'date_debut'=> 'date',
        'date_fin'=> 'date',
        'projet_id'
    ];//

    public function projet() {
        return $this->belongsTo(Projet::class);
    }

    public function statut() {
        return $this->belongsTo(Statut::class);
    } //
}
