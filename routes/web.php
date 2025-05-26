<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Immeubles;
use App\Livewire\ImmeublesAjouter;
use App\Livewire\Appartements;
use App\Livewire\AppartementsAjouter;
use App\Livewire\Employes;
use App\Livewire\EmployesAjouter;
use App\Livewire\Charges;
use App\Livewire\ChargesAjouter;
use App\Livewire\Residences;
use App\Livewire\ResidencesAjouter;
use App\Livewire\Historique;







// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Accès alternatif à la page d'accueil
Route::view('/welcome', 'welcome');

// Page de connexion
Route::get('/login', function () {
    return view('login'); // Crée resources/views/login.blade.php
})->name('login');

// Page d'inscription
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/dashboard', function () {
    return view('livewire.dashboard');
})->name('dashboard');

Route::get('/immeubles', function () {
    return view('livewire.immeubles');
})->name('immeubles');

Route::get('/immeubles/ajouter', function () {
    return view('livewire.immeubles-ajouter');
})->name('immeubles.ajouter');

Route::get('/appartements', function () {
    return view('livewire.appartements');
})->name('appartements');

Route::get('/appartements/ajouter', function () {
    return view('livewire.appartements-ajouter');
})->name('appartements.ajouter');

Route::get('/employes', function () {
    return view('livewire.employes');
})->name('employes');

Route::get('/employes/ajouter', function () {
    return view('livewire.employes-ajouter');
})->name('employes.ajouter');

// Résidences
Route::get('/residences', function () {
    return view('livewire.residences');
})->name('residences');

Route::get('/residences/ajouter', function () {
    return view('livewire.residences-ajouter');
})->name('residences.ajouter');

// Charges
Route::get('/charges', function () {
    return view('livewire.charges  ');
})->name('charges');

Route::get('/charges/ajouter', function () {
    return view('livewire.charges-ajouter');
})->name('charges.ajouter');


Route::post('/appartement/store', [AppartementController::class, 'store'])->name('appartement.store');
Route::post('/appartement/create', [AppartementController::class, 'create'])->name('appartement.create');




Route::post('/immeubles', [ImmeubleController::class, 'store'])->name('immeuble.store');
Route::post('/immeubles/create', [ImmeubleController::class, 'create'])->name('immeuble.create');
Route::post('/residences', [ResidenceController::class, 'store'])->name('residence.store');
Route::post('/residences/create', [ResidenceController::class, 'create'])->name('residence.create');
Route::post('/employes/stosre', [EmployeController::class, 'store'])->name('employe.store');
Route::post('/employes/create', [EmployeController::class, 'create'])->name('employe.create');

Route::get('/historique', function () {
    return view('livewire.historique');
})->name('historique');

