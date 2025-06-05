<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AppartementController;
use App\Http\Controllers\ImmeubleController;
use App\Livewire\ImmeublesAjouter;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\EmployeController;
use App\Livewire\Appartements;
use App\Livewire\AppartementsAjouter;
use App\Http\Controllers\ChargeController;
use App\Livewire\Charges;
use App\Http\Controllers\PaiementController;
use App\Http\Livewire\Paiements\Facture;
use App\Http\Controllers\DashboardController;




// Page d'accueil

Route::view('/', 'livewire.welcome')->name('home');



// Authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Dashboard
Route::get('/dashboard', function () {
    return view('livewire.dashboard');
})->name('dashboard');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');










//charge


Route::get('charges', [ChargeController::class, 'index'])->name('charges.index');
Route::get('charges/create', [ChargeController::class, 'create'])->name('charges.create');
Route::post('charges', [ChargeController::class, 'store'])->name('charge.store');
Route::get('charges/{charge}', [ChargeController::class, 'show'])->name('charges.show');
Route::get('charges/{charge}/edit', [ChargeController::class, 'edit'])->name('charges.edit');
Route::put('charges/{charge}', [ChargeController::class, 'update'])->name('charges.update');
Route::delete('charges/{charge}', [ChargeController::class, 'destroy'])->name('charges.destroy');
Route::get('/charges/ajouter', [ChargeController::class, 'ajouter'])->name('charges.ajouter');
Route::post('/charges/ajouter', [ChargeController::class, 'store'])->name('charges.ajouter');





Route::view('/historique', 'livewire.historique')->name('historique');











// Immeubles
// Route pour afficher la liste des immeubles
Route::get('/immeubles/ajouter', ImmeublesAjouter::class)->name('livewire.immeubles-ajouter');

// Route pour afficher le formulaire d'ajout d'un immeuble

// Route pour enregistrer un nouvel immeuble (POST)
Route::post('/immeubles/store', [ImmeubleController::class, 'store'])->name('immeubles.store');
Route::get('/immeubles', [ImmeubleController::class, 'index'])->name('immeubles');
Route::get('/immeubles/{id}/cotisation', [ImmeubleController::class, 'getCotisation'])->name('immeubles.cotisation');
Route::get('immeubles/{id}', [ImmeubleController::class, 'show'])->name('immeubles.show');
Route::get('immeubles/{id}/edit', [ImmeubleController::class, 'edit'])->name('immeubles.edit');
Route::get('immeubles/{id}/destroy', [ImmeubleController::class, 'destroy'])->name('immeubles.destroy');
Route::resource('immeubles', ImmeubleController::class);



// Résidences
Route::post('/residence/store', [ResidenceController::class, 'store'])->name('residence.store');
Route::get('/residences', [ResidenceController::class, 'index'])->name('residences');
Route::view('/residences', 'livewire.residences')->name('residences');
Route::view('/residences/ajouter', 'livewire.residences-ajouter')->name('residences.ajouter');
Route::resource('residences', ResidenceController::class);
Route::get('/residences', [ResidenceController::class, 'index'])->name('residences');




Route::get('/residences/{id}/info', [ResidenceController::class, 'getInfo'])->name('residences.info');
// Route resource complète (inclut index, create, store, show, edit, update, destroy)
Route::resource('residences', ResidenceController::class);

// Route vers le formulaire d’ajout d’un employé
Route::resource('employe', \App\Http\Controllers\EmployeController::class);
Route::get('/employes/ajouter', [EmployeController::class, 'create'])->name('livewire.employes-ajouter');

// Route de traitement du formulaire
Route::post('/employes', [EmployeController::class, 'store'])->name('employes.store');

// Liste des employés
Route::get('/employes', [EmployeController::class, 'index'])->name('livewire.employes');


Route::get('/employes/{id}/edit', [AppartementController::class, 'edit'])->name('employes.edit');
Route::delete('/employes/{id}', [AppartementController::class, 'destroy'])->name('employes.destroy');
Route::get('/emplyes/{id}', [AppartementController::class, 'show'])->name('employes.show');

//Appartements



Route::get('/appartements', [AppartementController::class, 'index'])->name('appartements.index');
Route::get('/appartements', [AppartementController::class, 'index'])->name('appartements');

Route::get('/appartements/ajouter', [AppartementController::class, 'create'])->name('appartements.ajouter');

Route::post('/appartements', [AppartementController::class, 'store'])->name('appartement.store');
Route::get('/appartements/{id}/edit', [AppartementController::class, 'edit'])->name('appartement.edit');
Route::put('/appartements/{id}', [AppartementController::class, 'update'])->name('appartement.update');
Route::delete('/appartements/{id}', [AppartementController::class, 'destroy'])->name('appartement.destroy');
Route::get('/appartements/{id}', [AppartementController::class, 'show'])->name('appartement.show');
Route::put('/appartements/{id}', [AppartementController::class, 'update'])->name('appartements.update');


// Facultatif : vous pouvez aussi utiliser cette ligne unique pour tout automatiser (mais attention aux doublons)
Route::resource('appartements', AppartementController::class);












// charge
Route::post('/charges', [ChargeController::class, 'store'])->name('charge.store');
Route::get('/charge/create', [ChargeController::class, 'create'])->name('charge.create');




Route::get('/charges', Charges::class)->name('livewire.charges');
// Livewire
//Route::get('/charges', Charges::class)->name('livewire.charges');

// Contrôleur
Route::get('/charges', [ChargeController::class, 'index'])->name('charges');

Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');


Route::get('/paiements/{id}/facture', [PaiementController::class, 'facture'])->name('paiements.facture');
