<?php

namespace App\Http\Controllers;

use App\Mail\InvitationAuProjet;
use App\Models\Fonction;
use App\Models\Personne;
use App\Models\PersonneFonctionProjet;
use App\Models\Projet;
use App\Models\ProjetStatut;
use App\Models\Statut;
use Carbon\Carbon;
//use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class ProjetController extends Controller
{
    public function create(Request $request)
    {
        $personnes = Personne::all();
        $statuts = Statut::all();
        return view('projet.create', compact('personnes', 'statuts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'personne_id' => ['required'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date'],
            'statut_id' => ['required'],

        ]);

        // dd($request->all());


        $fonction = Fonction::where('libelle', 'Chef Projet')->first();
        //dd($fonction->id);

        DB::BeginTransaction();
        try {


            $projet = new Projet();
            $projet->titre = $request->titre;
            $projet->description = $request->description;
            $projet->date_debut = $request->date_debut;
            $projet->date_fin = $request->date_fin;
            $projet->save();

            $personneFonctionprojet = new PersonneFonctionProjet();
            $personneFonctionprojet->personne_id = $request->personne_id;
            $personneFonctionprojet->fonction_id = $fonction->id;
            $personneFonctionprojet->projet_id = $projet->id;
            $personneFonctionprojet->actif = true;
            $personneFonctionprojet->date_debut = $request->date_debut;
            $personneFonctionprojet->date_fin = $request->date_fin;
            $personneFonctionprojet->save();

            $projetStatut = new ProjetStatut();
            $projetStatut->projet_id = $projet->id;
            $projetStatut->statut_id = $request->statut_id;
            $projetStatut->actif = true;
            $projetStatut->date_debut = $request->date_debut;
            $projetStatut->save();

            DB::commit();

            return back()->with('success','Projet créé avec succès');
        } catch (\Exception $e) {
            DB::rollBack(); // Annule toutes les modifications en cas d'erreur
            return back()->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer.']);
        }
    }

    public function index()
    {
        return view('projet.index');
    }

    public function data_projet($id)
    {
        // Récupérer uniquement les projets associés à l'utilisateur connecté
        $personne = Auth::user()->personne;
        if (!$personne) {
            return response()->json(['error' => 'Personne non trouvée'], 404);
        }
        // Récupérer les projets de cette personne
        $projets = $personne->projets()->withCount('membres')->get();


        //dd($projets );

        return DataTables::of($projets)
            ->addIndexColumn() // Ajout de l'index automatique
            ->editColumn('titre', function ($projet) {
                return $projet->titre;
            })
            ->editColumn('date_debut', function ($projet) {
                return $projet->date_debut ? Carbon::parse($projet->date_debut)->format('d/m/Y') : 'N/A';
            })
            ->editColumn('date_fin', function ($projet) {
                return $projet->date_fin ? Carbon::parse($projet->date_fin)->format('d/m/Y') : 'N/A';
            })

            ->addColumn('nombre_membres', function ($projet) {
                return $projet->membres_count ?? 0; // Assure que le champ existe
            })

            ->addColumn('action', function ($projet) {

                if (auth()->user()->hasPermissionF(['manage_project_task'], $projet->id)) {
                    return '
                    <a href="' . route('projet.show', $projet->id) . '" class="btn btn-sm btn-primary">Afficher</a>
                   ';
                } else {
                    return '<a href="' . route('projet.show', $projet->id) . '" class="btn btn-sm btn-primary">Afficher</a>';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($id)
    {
        $projet = Projet::with(['statutActuel.statut', 'taches', 'membres'])->findOrFail($id);
        $statuts = Statut::all();
        $personnes = $projet->membres;
        $allPersonnes = Personne::all();
        $rolesAttribues = $projet->membres->pluck('pivot.fonction_id')->toArray();

        // Récupérer uniquement les rôles non encore attribués
        $fonctions = Fonction::whereNotIn('id', $rolesAttribues)
            ->where('libelle', 'membre')->get();

        return view('projet.show', compact('projet', 'statuts', 'personnes', 'allPersonnes', 'fonctions'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'statut_id' => 'required|integer|exists:statuts,id', // Statut obligatoire
        ]);

        // 1️⃣ Mise à jour du projet
        $projet = Projet::findOrFail($id);
        $projet->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        // 2️⃣ Mise à jour de `ProjetStatut` (ou création si non existant)
        ProjetStatut::updateOrCreate(
            ['projet_id' => $id], // Condition pour chercher un enregistrement existant
            [
                'statut_id' => $request->statut_id,
                'actif' => true, // Active par défaut
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Projet mis à jour avec succès']);
    }



    public function invite(Request $request)
    {
        $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'personne_id' => 'required|exists:personnes,id',
            'email' => 'required|email',
        ]);

        // Récupérer le projet et la personne
        $projet = Projet::findOrFail($request->projet_id);
        $personne = Personne::findOrFail($request->personne_id);
        $email = $request->email;
        $fonction_id = $request->fonction_id;
        $fonction = Fonction::where('id', $fonction_id)->first();
        // Générer un token unique pour l'invitation
        $token = hash('sha256', time());

        // Sauvegarder le token dans la base (exemple : une table `invitations`)
        DB::table('invitations')->insert([
            'personne_id' => $personne->id,
            'fonction_id' => $fonction_id,
            'projet_id' => $projet->id,
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Construire le lien d'invitation
        $lienInvitation = route('projet.accept.invitation', ['token' => $token]);

        // Envoyer l'email
        Mail::to($email)->send(new InvitationAuProjet($projet, $lienInvitation, $fonction->libelle));

        return back()->with('success', 'Invitation envoyée avec succès !');
    }

    public function acceptInvitation($token)
    {
        // Vérifier si le token existe
        $invitation = DB::table('invitations')->where('token', $token)->first();

        if (!$invitation) {
            return redirect('/')->with('error', 'Invitation invalide ou expirée.');
        }

        // Récupérer l'utilisateur correspondant à l'email
        $personne = Personne::where('email', $invitation->email)->first();
        $projet = Projet::where('id', $invitation->projet_id)->first();

        if (!$personne) {
            return redirect('/')->with('error', 'Utilisateur introuvable.');
        }

        // Ajouter la personne au projet (ajoute un rôle par défaut, à adapter)
        $personneFonctionprojet = new PersonneFonctionProjet();
        $personneFonctionprojet->personne_id = $invitation->personne_id;
        $personneFonctionprojet->fonction_id = $invitation->fonction_id;
        $personneFonctionprojet->projet_id = $projet->id;
        $personneFonctionprojet->actif = true;
        $personneFonctionprojet->date_debut = $projet->date_debut;
        $personneFonctionprojet->date_fin = $projet->date_fin;
        $personneFonctionprojet->save();

        // Supprimer l'invitation après acceptation
        DB::table('invitations')->where('token', $token)->delete();

        return redirect()->route('login')->with('success', 'Invitation acceptée avec succès !');
    }

    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);

        // Vérifie si l'utilisateur a la permission de supprimer ce projet
        

        $projet->delete();

        return response()->json(['message' => 'Projet supprimé avec succès']);
    }
}
