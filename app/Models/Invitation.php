<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable=['personne_id', 'fonction_id','projet_id','email','token'];//
}
