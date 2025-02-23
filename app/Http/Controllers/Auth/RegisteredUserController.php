<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Personne;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prenom'=>['required', 'string', 'max:255'],
            'tel'=>['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();
        try{

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        
        $personne = Personne::create([
            'nom' => $request->name,
            'prenom' => $request->prenom,
            'tel' => $request->tel,
            'email' => $request->email,
            'user_id'=>$user->id
        ]);
        $personne->save();

        DB::commit();


        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    } catch (\Exception $e) {
        DB::rollBack(); // Annule toutes les modifications en cas d'erreur
        return back()->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer.']);
    
    }
    }
}