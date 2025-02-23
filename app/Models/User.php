<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function personne()
    {
        return $this->hasOne(Personne::class);
    }

    public function getRoleName()
    {
        if ($this->personne && $this->personne->actif_fonctions->isNotEmpty()) {
            return $this->personne->actif_fonctions->first()->roles->pluck('name')->first() ?? 'Aucun rôle';    }
    
        return $this->getRoleNames()->first() ?? 'Aucun rôle';
    }
    
    public function hasPermissionF(array $permissions, $projet_id): bool
    {
        if (!$this->personne) {
            return false;
        }
    
        return $this->personne->actif_fonctions($projet_id) // Correctement appelé avec $projet_id
            ->with('roles.permissions') // Charge les rôles et permissions en une seule requête
            ->get()
            ->flatMap(fn($fonction) => $fonction->roles)
            ->flatMap(fn($role) => $role->permissions)
            ->pluck('name')
            ->intersect($permissions)
            ->isNotEmpty();
    }
    

    
    
    

}
