<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    protected $fillable=['libelle'];//

  public function taches()
  {
    return $this->hasMany(Tache::class);
  } 


}
