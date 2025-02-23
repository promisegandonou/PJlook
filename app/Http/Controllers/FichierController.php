<?php

namespace App\Http\Controllers;

use App\Models\Fichier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FichierController extends Controller
{
    public function store(Request $request, $id)
{
    $request->validate([
        'fichiers' => 'required',
        'fichiers.*' => 'file|max:10240', // Chaque fichier max 10 MB
        'tache_id' => 'nullable|exists:taches,id', // Vérifie si la tâche existe bien
    ]);

    $fichiers = is_array($request->file('fichiers')) ? $request->file('fichiers') : [$request->file('fichiers')];

    foreach ($fichiers as $fichier) {
        if ($fichier) {
            $nomFichier = time() . '_' . $fichier->getClientOriginalName();
            $chemin = $fichier->storeAs('fichiers', $nomFichier, 'public');

            Fichier::create([
                'nom' => $nomFichier,
                'chemin' => $chemin,
                'projet_id' => $id, // Toujours lié à un projet
                'tache_id' => $request->tache_id, // Peut être NULL si ce n'est pas une tâche
            ]);
        }
    }

    return back()->with('success', 'Fichier(s) téléchargé(s) avec succès.');
}

    

    public function download($id)
    {
        $fichier = Fichier::findOrFail($id);
        return Storage::disk('public')->download($fichier->chemin, $fichier->nom);
    }

    public function destroy($id)
    {
        $fichier = Fichier::findOrFail($id);
        Storage::disk('public')->delete($fichier->chemin);
        $fichier->delete();

        return back()->with('success', 'Fichier supprimé avec succès.');
    }
}//

