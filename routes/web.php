<?php

use App\Http\Controllers\FichierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route for project//

Route::get('/projet/create',[ProjetController::class, 'create'])->name('projet.create');

Route::post('/projet/store',[ProjetController::class, 'store'])->name('projet.store');

Route::get('/projet/index',[ProjetController::class, 'index'])->name('projet.index');

Route::get('/projet/datatable/{id}', [ProjetController::class, 'data_projet'])->name('projets_datatable');
Route::get('/projet/show/{id}', [ProjetController::class, 'show'])->name('projet.show');
Route::post('/projet/invite/member', [ProjetController::class, 'invite'])->name('projet.send.invitation');
Route::get('/projet/accept/invitation/{token}', [ProjetController::class, 'acceptInvitation'])->name('projet.accept.invitation');

Route::put('/projet/update/{id}', [ProjetController::class, 'update' ])->name('projet.update');
Route::delete('/projets/{id}', [ProjetController::class, 'destroy'])->name('projets.destroy');


//End Route for project//

//Route fortache//
Route::get('/tache/create',[TacheController::class, 'create'])->name('tache.create');

Route::post('/tache/store',[TacheController::class, 'store'])->name('tache.store');

Route::get('/tache/index',[TacheController::class, 'index'])->name('tache.index');

Route::get('/tache/datatable/{id}', [TacheController::class, 'data_tache'])->name('taches_datatable');


Route::get('/taches/{id}/edit', [TacheController::class, 'edit']);
Route::put('/taches/{id}', [TacheController::class, 'update']);
Route::put('/tache/{id}/statut', [TacheController::class, 'updateStatut'])->name('tache.updateStatut');

Route::delete('/taches/{id}', [TacheController::class, 'destroy'])->name('taches.destroy'); // 🔥 PLACE LA ROUTE ICI

Route::get('/taches/{id}', [TacheController::class, 'show'])->name('taches.show');




//End Route fortache//

//Route for Fichiers


Route::post('/fichiers/upload/{id}', [FichierController::class, 'store'])->name('fichiers.upload');
Route::get('/fichiers/download/{id}', [FichierController::class, 'download'])->name('fichiers.download');
Route::delete('/fichiers/delete/{id}', [FichierController::class, 'destroy'])->name('fichiers.delete');


//End route for Fichier




require __DIR__.'/auth.php';
