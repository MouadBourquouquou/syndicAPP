<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Assistant\DashboardController as AssistantDashboardController;
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
use App\Http\Controllers\Auth\ResetPasswordController;


use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Immeuble;


// ============================
// ADMIN ROUTES
// ============================
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admins', [\App\Http\Controllers\AdminController::class, 'listeAdmins'])->name('admins.index');
    Route::get('/admins/create', [\App\Http\Controllers\AdminController::class, 'createAdmin'])->name('admins.create');
    Route::post('/admins', [\App\Http\Controllers\AdminController::class, 'storeAdmin'])->name('admins.store');
    Route::delete('/admins/{id}', [\App\Http\Controllers\AdminController::class, 'destroyAdmin'])->name('admins.destroy');
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/syndics', [\App\Http\Controllers\AdminController::class, 'listSyndics'])->name('syndics');
    Route::delete('/syndics/{id}/delete', [\App\Http\Controllers\AdminController::class, 'disableSyndic'])->name('syndics.delete');
    Route::get('/syndics/{id}/show', [\App\Http\Controllers\AdminController::class, 'showSyndic'])->name('syndics.show');
    Route::get('/syndics/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editSyndic'])->name('syndics.edit');
    

    Route::get('/demandes', [\App\Http\Controllers\AdminController::class, 'listDemandes'])->name('demandes');
    Route::post('/demandes/{id}/activer', [\App\Http\Controllers\AdminController::class, 'activerDemande'])->name('demandes.activer');
    Route::post('/demandes/{id}/refuser', [\App\Http\Controllers\AdminController::class, 'refuserDemande'])->name('demandes.refuser');
});

Route::get('password/reset/{token}', [\App\Http\Controllers\AppResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::get('/api/residences', function(Request $request) {
    $ville = $request->get('ville');

    if ($ville) {
        return \App\Models\Residence::where('ville', $ville)
                                    ->where('id_S', Auth::id())
                                    ->get();
    }

    return \App\Models\Residence::where('id_S', Auth::id())->get();
});

Route::get('/api/immeubles', function(Request $request) {
    $residenceId = $request->get('residence_id');
    $ville = $request->get('ville');

    if (!$ville) {
        return response()->json([], 200);
    }

    $query = \App\Models\Immeuble::query();

    // Filtrer par ville + id_S
    $query->where(function($q) use ($ville, $residenceId) {
        $q->where('ville', $ville)
          ->whereNull('residence_id')
          ->where('id_S', Auth::id());

        $q->orWhereHas('residence', function($subQuery) use ($ville) {
            $subQuery->where('ville', $ville)
                     ->where('id_S', Auth::id());
        });
    });

    if ($residenceId) {
        $query->where('residence_id', $residenceId);
    }

    $query->with('residence');
    $immeubles = $query->get();

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

// Dashboard syndic

Route::middleware(['auth', \App\Http\Middleware\SyndicMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Liste des charges
    Route::get('/immeubles/by-residence/{residenceId}', [App\Http\Controllers\ImmeubleController::class, 'apiByResidence']);
// Liste des charges (index)
Route::get('/charges', [ChargeController::class, 'index'])->name('charges.index');

// Formulaire pour ajouter une charge
Route::get('/charges/ajouter', [ChargeController::class, 'create'])->name('charges.ajouter');


// Enregistrer une charge (POST)
Route::post('/charges', [ChargeController::class, 'store'])->name('charge.store');

// Formulaire d'édition d'une charge
Route::get('/charges/{charge}/edit', [ChargeController::class, 'edit'])->name('charges.edit');

// Mettre à jour une charge (PUT/PATCH)
Route::put('/charges/{charge}', [ChargeController::class, 'update'])->name('charges.update');

// Supprimer une charge (DELETE)
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





    Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');
    Route::get('/paiements/{id}/facture', [PaiementController::class, 'facture'])->name('paiements.facture');
    Route::get('/paiements/historique', [PaiementController::class, 'historique'])->name('paiements.historique');

    Route::get('/paiements', [PaiementController::class, 'historique'])->name('paiements.index');


    Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');

    });


// Assistant routes
Route::middleware(['auth', \App\Http\Middleware\AssistantMiddleware::class])->prefix('assistant')->name('assistant.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Assistant\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/historique', [\App\Http\Controllers\Assistant\DashboardController::class, 'historique'])->name('historique');

    // Charges routes
    Route::get('/charges', [\App\Http\Controllers\Assistant\ChargeController::class, 'index'])->name('charges.index');
    Route::get('/charges/ajouter', [\App\Http\Controllers\Assistant\ChargeController::class, 'create'])->name('charges.create');
    Route::post('/charges', [\App\Http\Controllers\Assistant\ChargeController::class, 'store'])->name('charge.store');
    Route::get('/charges/{charge}/edit', [\App\Http\Controllers\Assistant\ChargeController::class, 'edit'])->name('charges.edit');
    Route::put('/charges/{charge}', [\App\Http\Controllers\Assistant\ChargeController::class, 'update'])->name('charges.update');
    Route::delete('/charges/{charge}', [\App\Http\Controllers\Assistant\ChargeController::class, 'destroy'])->name('charges.destroy');
    Route::get('/charges/{charge}', [\App\Http\Controllers\Assistant\ChargeController::class, 'show'])->name('charges.show');

    // Paiements routes
    Route::get('/paiements', [\App\Http\Controllers\Assistant\PaiementController::class, 'index'])->name('paiements.index');
    Route::get('/paiements/ajouter', [\App\Http\Controllers\Assistant\PaiementController::class, 'create'])->name('paiements.create');
    Route::post('/paiements', [\App\Http\Controllers\Assistant\PaiementController::class, 'store'])->name('paiements.store');
    Route::get('/paiements/{id}/facture', [\App\Http\Controllers\Assistant\PaiementController::class, 'facture'])->name('paiements.facture');
    Route::get('/paiements/historique', [\PaiementController::class, 'historique'])->name('paiements.historique');

    // Immeubles routes
    Route::get('/immeubles', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'index'])->name('immeubles.index');
    Route::get('/immeubles/ajouter', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'create'])->name('immeubles.create');
    Route::post('/immeubles/store', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'store'])->name('immeubles.store');
    Route::get('/immeubles/{id}/cotisation', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'getCotisation'])->name('immeubles.cotisation');
    Route::get('/immeubles/{id}', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'show'])->name('immeubles.show');
    Route::get('/immeubles/{id}/edit', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'edit'])->name('immeubles.edit');
    Route::put('/immeubles/{id}', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'update'])->name('immeubles.update');
    Route::delete('/immeubles/{id}', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'destroy'])->name('immeubles.destroy');

    // Résidences routes
    Route::get('/residences', [ResidenceController::class, 'index'])->name('residences.index');
    Route::get('/residences/ajouter', [ResidenceController::class, 'create'])->name('residences.create');
    Route::post('/residence/store', [ResidenceController::class, 'store'])->name('residence.store');
    Route::get('/residences/{id}/info', [ResidenceController::class, 'getInfo'])->name('residences.info');
    Route::get('/residences/{id}/edit', [ResidenceController::class, 'edit'])->name('residences.edit');
    Route::put('/residences/{id}', [ResidenceController::class, 'update'])->name('residences.update');
    Route::delete('/residences/{id}', [ResidenceController::class, 'destroy'])->name('residences.destroy');

    // Appartements routes
    Route::get('/appartements', [\App\Http\Controllers\Assistant\AppartementController::class, 'index'])->name('appartements.index');
    Route::get('/appartements/ajouter', [\App\Http\Controllers\Assistant\AppartementController::class, 'create'])->name('appartements.create');
    Route::post('/appartements', [\App\Http\Controllers\Assistant\AppartementController::class, 'store'])->name('appartements.store');
    Route::get('/appartements/{id}/edit', [\App\Http\Controllers\Assistant\AppartementController::class, 'edit'])->name('appartement.edit');
    Route::put('/appartements/{id}', [\App\Http\Controllers\Assistant\AppartementController::class, 'update'])->name('appartement.update');
    Route::delete('/appartements/{id}', [\App\Http\Controllers\Assistant\AppartementController::class, 'destroy'])->name('appartement.destroy');
    Route::get('/appartements/{id}', [\App\Http\Controllers\Assistant\AppartementController::class, 'show'])->name('appartements.show');
});