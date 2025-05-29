<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AppartementController;
use App\Http\Controllers\ImmeubleController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\EmployeController;
use App\Livewire\Appartements;
use App\Livewire\AppartementsAjouter;
use App\Http\Controllers\ChargeController;
use App\Livewire\Charges;

// Page d'accueil
Route::view('/', 'welcome')->name('home');
Route::view('/welcome', 'welcome');

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
Route::resource('employe', \App\Http\Controllers\EmployeController::class);

Route::view('/appartements', 'livewire.appartements')->name('appartements');

Route::get('/appartements/ajouter', [AppartementController::class, 'create'])->name('appartements.ajouter');

Route::view('/residences', 'livewire.residences')->name('residences');
Route::view('/residences/ajouter', 'livewire.residences-ajouter')->name('residences.ajouter');
Route::view('/charges', 'livewire.charges')->name('charges');
Route::get('/charges/ajouter', [ChargeController::class, 'create'])->name('charges.ajouter');

Route::view('/historique', 'livewire.historique')->name('historique');

// --- Routes contrôleurs ---

// Appartements
Route::post('/appartements/store', [AppartementController::class, 'store'])->name('appartement.store');

// Immeubles
Route::resource('immeuble', ImmeubleController::class);
Route::get('/immeubles/ajouter', function () {return view('livewire.immeubles-ajouter');
})->name('immeubles.ajouter');
Route::get('/immeubles', function () {
    return view('livewire.immeubles');})->name('immeubles');

// Résidences
Route::post('/residence/store', [ResidenceController::class, 'store'])->name('residence.store');
Route::get('/residences', [ResidenceController::class, 'index'])->name('residences');

// Route vers le formulaire d’ajout d’un employé
Route::get('/employes/ajouter', [EmployeController::class, 'create'])->name('employes.ajouter');

// Route de traitement du formulaire
Route::post('/employes', [EmployeController::class, 'store'])->name('employe.store');

// Liste des employés
Route::get('/employes', [EmployeController::class, 'index'])->name('livewire.employes');

Route::resource('employes', EmployeController::class);
Route::get('/employes', [EmployeController::class, 'index'])->name('employes');





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



