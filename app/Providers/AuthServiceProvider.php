<?php

namespace App\Providers;

use App\Models\Projet;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
        Gate::before(function ($user, $permission, $arguments) {
            // Vérifier si l'utilisateur a un accès direct via une permission attribuée
            if (!$user->personne) {
                return $user->hasPermissionTo($permission);
            }
    
            // Vérifier si un projet est fourni (sinon on bloque par défaut)
            if (empty($arguments)) {
                return null; // Laravel continue les vérifications normales
            }
    
            // Récupérer l'ID du projet depuis les arguments
            $projet_id = $arguments[0]->id ?? null;
            
            if (!$projet_id) {
                return null; // Aucun projet fourni, on ne donne pas d'autorisation
            }
    
            // Vérifier la permission de l'utilisateur pour ce projet spécifique
            return $user->hasPermissionF([$permission], $projet_id);

        //
    });
    }
         //
    }

