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

// Pages Livewire (vues statiques) sans doublon d'URL


Route::view('/appartements', 'livewire.appartements')->name('appartements');

Route::get('/appartements/ajouter', [AppartementController::class, 'create'])->name('appartements.ajouter');

Route::view('/residences', 'livewire.residences')->name('residences');
Route::view('/residences/ajouter', 'livewire.residences-ajouter')->name('residences.ajouter');

Route::get('/residences/{residence}/immeubles', [ResidenceController::class, 'getImmeubles'])
    ->name('residences.immeubles');
Route::view('/charges', 'livewire.charges')->name('charges');
Route::get('/charges/ajouter', [ChargeController::class, 'create'])->name('charges.ajouter');

Route::view('/historique', 'livewire.historique')->name('historique');

// --- Routes contrôleurs ---

// Appartements
Route::post('/appartements/store', [AppartementController::class, 'store'])->name('appartement.store');



// Immeubles
// Route pour afficher la liste des immeubles
Route::get('/immeubles/ajouter', ImmeublesAjouter::class)->name('livewire.immeubles-ajouter');

// Route pour afficher le formulaire d'ajout d'un immeuble

// Route pour enregistrer un nouvel immeuble (POST)
Route::post('/immeubles/store', [ImmeubleController::class, 'store'])->name('immeubles.store');
Route::get('/immeubles', [ImmeubleController::class, 'index'])->name('immeubles');
Route::get('/immeubles/{id}/cotisation', [ImmeubleController::class, 'getCotisation'])->name('immeubles.cotisation');
Route::get('/immeubles/tous', [ImmeubleController::class, 'tous']);




// Résidences
Route::post('/residence/store', [ResidenceController::class, 'store'])->name('residence.store');
Route::get('/residences', [ResidenceController::class, 'index'])->name('residences');
// web.php
Route::get('/residences/{id}/info', [ResidenceController::class, 'getInfo'])->name('residences.info');
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



// Ressource appartement (si besoin)
Route::resource('appartements', AppartementController::class);
Route::get('/appartements', [AppartementController::class, 'index'])->name('appartements');



Route::get('/appartements/{id}/edit', [AppartementController::class, 'edit'])->name('appartement.edit');



Route::delete('/appartements/{id}', [AppartementController::class, 'destroy'])->name('appartement.destroy');

Route::get('/appartements/{id}', [AppartementController::class, 'show'])->name('appartement.show');

Route::get('/appartements/create', [AppartementController::class, 'create'])->name('appartement.create');




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
