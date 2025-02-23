<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fichier extends Model
{
     protected $fillable = ['nom', 'chemin', 'projet_id', 'tache_id'];

     public function projet()
     {
         return $this->belongsTo(Projet::class);
     }
 
     public function tache()
     {
         return $this->belongsTo(Tache::class);
     }
}
