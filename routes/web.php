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
use App\Http\Livewire\Employes;
use App\Livewire\EmployesAjouter;


use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Immeuble;

Route::get('/api/residences', function(Request $request) {
    $ville = $request->get('ville');
    
    if ($ville) {
        return Residence::where('ville', $ville)->get();
    }
    
    return Residence::all();
});
Route::get('/api/immeubles', function(Request $request) {
    $residenceId = $request->get('residence_id');
    $ville = $request->get('ville');
    
    \Log::info('API immeubles request:', [
        'ville' => $ville,
        'residence_id' => $residenceId
    ]);

    if (!$ville) {
        return response()->json([], 200);
    }

    $query = Immeuble::query();

    // Always filter by ville first
    $query->where(function($q) use ($ville, $residenceId) {
        // Immeubles that directly match the ville (no residence)
        $q->where('ville', $ville)
          ->whereNull('residence_id');
        
        // OR immeubles that belong to a residence in the ville
        $q->orWhereHas('residence', function($subQuery) use ($ville) {
            $subQuery->where('ville', $ville);
        });
    });

    // If residence_id is provided, further filter by residence
    if ($residenceId) {
        $query->where('residence_id', $residenceId);
    }

    $query->with('residence');
    $immeubles = $query->get();

    \Log::info('API immeubles results:', [
        'count' => $immeubles->count(),
        'sql' => $query->toSql(),
        'bindings' => $query->getBindings()
    ]);

    return response()->json($immeubles);
});
// Page d'accueil

Route::view('/', 'livewire.welcome')->name('home');



// Authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Dashboard

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});




// Liste des charges
Route::get('/charges', [ChargeController::class, 'index'])->name('charges.index');

// Formulaire pour ajouter une nouvelle charge
Route::get('/charges/ajouter', [ChargeController::class, 'create'])->name('charges.create');

// Enregistrer la nouvelle charge
Route::post('/charges', [ChargeController::class, 'store'])->name('charges.store');

// Formulaire d'édition d'une charge
Route::get('/charges/{charge}/edit', [ChargeController::class, 'edit'])->name('charges.edit');

// Mettre à jour une charge
Route::put('/charges/{charge}', [ChargeController::class, 'update'])->name('charges.update');

// Supprimer une charge
Route::delete('/charges/{charge}', [ChargeController::class, 'destroy'])->name('charges.destroy');


// Historique des paiements
Route::get('/historique', [PaiementController::class, 'historique'])->name('historique');












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
Route::put('/immeubles/{id}', [ImmeubleController::class, 'update'])->name('immeubles.update');
Route::put('/immeubles', [ImmeubleController::class, 'index'])->name('immeubles.index');

Route::get('/api/immeubles', [ImmeubleController::class, 'apiIndex']);






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
Route::delete('/employes/{id_E}', [App\Http\Controllers\EmployeController::class, 'destroy'])->name('employes.destroy');
Route::put('/employes/{id_E}', [App\Http\Controllers\EmployeController::class, 'update'])->name('employes.update');



//Appartements
Route::get('/appartements/ajouter', [AppartementController::class, 'create'])->name('appartements.ajouter');

Route::post('/appartements', [AppartementController::class, 'store'])->name('appartemenst.store');
Route::get('/appartements', [AppartementController::class, 'index'])->name('appartements.index');
Route::get('/appartements/{id}/edit', [AppartementController::class, 'edit'])->name('appartement.edit');
Route::put('/appartements/{id}', [AppartementController::class, 'update'])->name('appartement.update');
Route::delete('/appartements/{id}', [AppartementController::class, 'destroy'])->name('appartement.destroy');
Route::get('/appartements/{id}', [AppartementController::class, 'show'])->name('appartement.show');
Route::resource('appartements', AppartementController::class);



// charge
Route::post('/charge', [ChargeController::class, 'store'])->name('charge.store');
Route::resource('charges', ChargeController::class);
Route::get('/charge', [ChargeController::class, 'index'])->name('livewire.charges-ajouter');
Route::get('/charges', Charges::class)->name('livewire.charges');
//Route::get('/charges', Charges::class)->name('livewire.charges');
Route::get('/charges', [ChargeController::class, 'index'])->name('charges');
Route::get('/charges/ajouter', [ChargeController::class, 'create'])->name('charges.ajouter');

Route::get('/charges', [ChargeController::class, 'index'])->name('charges.index');


Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');
Route::get('/paiements/{id}/facture', [PaiementController::class, 'facture'])->name('paiements.facture');
Route::get('/paiements/historique', [PaiementController::class, 'historique'])->name('paiements.historique');

Route::get('/paiements', [PaiementController::class, 'historique'])->name('paiements.index');


Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');






