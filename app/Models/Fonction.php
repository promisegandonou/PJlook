<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Permission\Traits\HasRoles;


class Fonction extends Model
{
    use HasFactory, HasRoles;
    protected $fillable= [
        
        'libelle',
    ];

    protected $with = ['roles', 'permissions'];
    protected $guard_name = 'web';


    //

   public function personnes()
   {
    return $this->belongsToMany(Personne::class);
   }
}
