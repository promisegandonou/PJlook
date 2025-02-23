<?php

namespace App\Http\Controllers;

use App\Models\Personne;
use App\Models\Projet;
use App\Models\Statut;
use App\Models\Tache;
use App\Models\User;
use App\Notifications\TacheAssigneeNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TacheController extends Controller
{
   
    public function store(Request $request)
    {
        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description'=>['required', 'string', 'max:255'],
            'personne_id',
            'projet_id',

            'date_debut' => [ 'date'],
            'date_echeance' => ['date'],
            'statut_id',

        ]);

        if(is_null($request->personne_id)){
        $personne_id=null;
        $statut_id=Statut::where('libelle','En attente')->get('id');
        $date_debut=null;
        $date_echeance=null;

        }
        else
        {
            $personne_id=$request->personne_id;
            $statut_id=$request->statut_id;
            $date_debut=$request->date_debut;
            $date_echeance=$request->date_echeance;
        }

       

        DB::BeginTransaction();
        try{


            
             $tache=new Tache();
             $tache->titre=$request->titre;
             $tache->description=$request->description;
             $tache->date_debut=$date_debut;
             $tache->date_echeance=$date_echeance;
             $tache->personne_id=$personne_id;
             $tache->projet_id=$request->projet_id;
             $tache->statut_id=$statut_id;

             $tache->save();

             DB::commit();
             $personne=Personne::where('id',$personne_id)->get();
             $user_id=$personne->user_id;

             // Vérifier si une personne est assignée à la tâche
             if ($request->personne_id) {
                $user = User::find($user_id);
                if ($user) {
                    $user->notify(new TacheAssigneeNotification($tache));
                dd('yes')     ;
           } else {
                    Log::error("Utilisateur introuvable pour l'ID : {$request->personne_id}");
                }
            }


             return redirect()->back()->with('success', 'Tâche ajoutée avec succès!');
            }
        catch (\Exception $e) {
            DB::rollBack(); // Annule toutes les modifications en cas d'erreur
            return back()->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer.']);
        
        }

    }
   
    public function index()
    {
        return view ('projet.index');
    }

    public function data_tache($id) 
    {
        $projet = Projet::findOrFail($id);
        $taches = $projet->taches()->with('statut')->get();
    
        return DataTables::of($taches)
            ->addIndexColumn()
            ->addColumn('statut', function ($tache) {
                return $tache->statut 
                    ? '<span class="badge bg-info">' . e($tache->statut->libelle) . '</span>' 
                    : 'Non défini';
            })
            ->editColumn('date_debut', function ($tache) {
                return $tache->date_debut 
                    ? Carbon::parse($tache->date_debut)->format('d/m/Y') 
                    : 'Non assignée';
            })
            ->editColumn('date_echeance', function ($tache) {
                return $tache->date_echeance 
                    ? Carbon::parse($tache->date_echeance)->format('d/m/Y') 
                    : 'Non assignée';
            })
            ->addColumn('actions', function ($tache) use ($projet) {
                $buttons = '<a href="'. route('taches.show', $tache->id) .'" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> Afficher
            </a>';
    
                if (auth()->user()->hasPermissionF(['manage_project_task'], $projet->id)) {
                    $buttons .= '
                        <button class="btn btn-primary btn-sm btn-edit" data-id="' . $tache->id . '">
                            <i class="fas fa-edit"></i> Modifier
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="' . $tache->id . '">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                    
                    ';
                }
    
                return $buttons;
            })
            ->rawColumns(['statut', 'actions'])
            ->make(true);
    }
    
    
    public function show($id)
    {
        $tache = Tache::with(['statut', 'projet.taches.fichiers', 'personne'])->findOrFail($id);
        $statuts = Statut::all(); // Récupérer tous les statuts
    
        return view('tache.show', compact('tache', 'statuts'));
    }
    
    
    public function edit($id)
{
    $tache = Tache::find($id);

    if (!$tache) {
        return response()->json(['error' => 'Tâche non trouvée'], 404);
    }

    return response()->json($tache);
}

public function update(Request $request, $id)
{
    // Valider les données
    $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date_debut' => 'required|date',
        'date_echeance' => 'required|date|after_or_equal:date_debut',
    ]);

    // Trouver la tâche
    $tache = Tache::find($id);

    if (!$tache) {
        return response()->json(['error' => 'Tâche non trouvée'], 404);
    }

    // Mettre à jour les données
    $tache->titre = $request->titre;
    $tache->description = $request->description;
    $tache->date_debut = $request->date_debut;
    $tache->date_echeance = $request->date_echeance;
    $tache->update(); // Sauvegarde

    return response()->json(['message' => 'Tâche mise à jour avec succès !']);
}

public function updateStatut(Request $request, $id)
{
    $tache = Tache::findOrFail($id);
    $tache->statut_id = $request->statut_id;
    $tache->save();

    return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
}

public function destroy($id)
{
    $tache = Tache::findOrFail($id);
    $tache->delete();

    return response()->json(['message' => 'Tâche supprimée avec succès !']);
}



//
}
