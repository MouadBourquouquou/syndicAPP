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
use App\Http\Controllers\AppResetPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Notifications\TestNotification;


use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Immeuble;
use App\Models\Employe;


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

Route::get('password/reset/{token}', [AppResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('password/reset', [AppResetPasswordController::class, 'reset'])
    ->name('password.update');


Route::get('/api/residences', function (Request $request) {
    $ville = $request->get('ville');
    $user = Auth::user();

    if ($user->statut !== 'assistant_syndic') {
        $query = Residence::where('id_S', $user->id);
        if ($ville) {
            $query->where('ville', $ville);
        }
        return $query->get();
    }

    // Si assistant syndic
    if ($user->statut === 'assistant_syndic') {
        // récupérer l’employé lié à ce user
        $employe = \App\Models\Employe::where('email', $user->email)->first();

        // récupère les immeubles de l’assistant
        $immeubleIds = $employe->immeubles()->pluck('immeubles.id');

        // récupérer les résidences associées à ces immeubles
        $residenceIds = Immeuble::whereIn('id', $immeubleIds)
            ->pluck('residence_id')
            ->unique()
            ->filter(); // ignore null

        $query = Residence::whereIn('id', $residenceIds);
        if ($ville) {
            $query->where('ville', $ville);
        }

        return $query->get();
    }

    return response()->json([], 403);
});


Route::get('/api/immeubles', function (Request $request) {
    $ville = $request->get('ville');
    $residenceId = $request->get('residence_id');
    $user = Auth::user();

    if (!$ville) {
        return response()->json([], 200);
    }

    $query = Immeuble::query();

    if ($user->statut !== 'assistant_syndic') {
        $query->where('ville', $ville)->where('id_S', $user->id);

        if ($residenceId) {
            $query->where('residence_id', $residenceId);
        }

        return $query->with('residence')->get();
    }

    if ($user->statut === 'assistant_syndic') {
        $employe = \App\Models\Employe::where('email', $user->email)->first();

        $immeubleIds = $employe->immeubles()->pluck('immeubles.id');

        $query->whereIn('id', $immeubleIds)->where('ville', $ville);

        if ($residenceId) {
            $query->where('residence_id', $residenceId);
        }

        return $query->with('residence')->get();
    }

    return response()->json([], 403);
});


Route::get('/test-notif', function () {
    $user = User::first(); // Make sure this user exists in DB

    $user->notify(new TestNotification());

    return 'Test notification sent';
});

// Page d'accueil

Route::view('/', 'livewire.welcome')->name('home');



// Authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');


// Profile routes
Route::middleware(['auth', \App\Http\Middleware\SyndicOrAssistantMiddleware::class])->group(function () {
    Route::get('/Profile', [ProfileController::class, 'index'])->name('Profile');
    Route::put('/Profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Dashboard syndic

Route::middleware(['auth', \App\Http\Middleware\SyndicMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Liste des charges
    Route::get('/immeubles/by-residence/{residenceId}', [App\Http\Controllers\ImmeubleController::class, 'apiByResidence']);
    // Liste des charges (index)
    Route::get('/charges', [ChargeController::class, 'index'])->name('charges.index');

    // Formulaire pour ajouter une charge
    Route::get('/charges/ajouter', [ChargeController::class, 'create'])->name('charges.ajouter');
    Route::post('/charge', [ChargeController::class, 'store'])->name('charge.store');


    // Enregistrer une charge (POST)

    // Formulaire d'édition d'une charge
    Route::get('/charges/{charge}/edit', [ChargeController::class, 'edit'])->name('charges.edit');

    // Mettre à jour une charge (PUT/PATCH)
    Route::put('/charges/{charge}', [ChargeController::class, 'update'])->name('charges.update');

    // Supprimer une charge (DELETE)
    Route::delete('/charges/{charge}', [ChargeController::class, 'destroy'])->name('charges.destroy');


    // Historique des paiements
    Route::get('/historique', [PaiementController::class, 'historique'])->name('historique');




    // Immeubles
    Route::get('/immeubles/ajouter', [ImmeubleController::class, 'create'])->name('immeubles-ajouter');
    Route::post('/immeubles/store', [ImmeubleController::class, 'store'])->name('immeubles.store');
    Route::get('/immeubles', [ImmeubleController::class, 'index'])->name('immeubles');
    Route::get('/immeubles/{id}/cotisation', [ImmeubleController::class, 'getCotisation'])->name('immeubles.cotisation');
    Route::get('immeubles/{id}', [ImmeubleController::class, 'show'])->name('immeubles.show');
    Route::get('immeubles/{id}/edit', [ImmeubleController::class, 'edit'])->name('immeubles.edit');
    Route::delete('immeubles/{id}/destroy', [ImmeubleController::class, 'destroy'])->name('immeubles.destroy');
    Route::put('/immeubles/{id}', [ImmeubleController::class, 'update'])->name('immeubles.update');
    Route::put('/immeubles', [ImmeubleController::class, 'index'])->name('immeubles.index');
    Route::get('/api/immeubles', [ImmeubleController::class, 'apiIndex']);


    Route::middleware(['auth'])->group(function () {
        // Notification routes
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
            ->middleware('auth')
            ->name('notifications.read');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications/delete-read', [NotificationController::class, 'deleteAllRead'])->name('notifications.delete-read');
        Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
        
    });




    // Résidences
    Route::post('/residence/store', [ResidenceController::class, 'store'])->name('residence.store');
    Route::get('/residences', [ResidenceController::class, 'index'])->name('residences');
    Route::view('/residences', 'livewire.residences')->name('residences');
    Route::view('/residences/ajouter', 'livewire.residences-ajouter')->name('residences.ajouter');
    Route::resource('residences', ResidenceController::class);
    Route::get('/residences', [ResidenceController::class, 'index'])->name('residences');
    Route::get('/residences/{id}/info', [ResidenceController::class, 'getInfo'])->name('residences.info');


    //employes
    Route::get('/employes/ajouter', [EmployeController::class, 'create'])->name('livewire.employes-ajouter');
    Route::post('/employes', [EmployeController::class, 'store'])->name('employes.store');
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




    // Paiements
    Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');
    Route::get('/paiements/{id}/facture', [PaiementController::class, 'facture'])->name('paiements.facture');
    Route::get('/paiements/historique', [PaiementController::class, 'historique'])->name('paiements.historique');
    Route::get('/paiements', [PaiementController::class, 'historique'])->name('paiements.index');
    Route::get('/paiements', [PaiementController::class, 'index'])->name('paiements.index');
});


// Assistant routes 
Route::middleware(['auth', \App\Http\Middleware\AssistantMiddleware::class])->prefix('assistant')->name('assistant.')->group(function () {
    Route::get('/dashboard', [AssistantDashboardController::class, 'index'])->name('dashboard');

    // Charges - Assistant (accès complet autorisé)
    Route::get('/charges', [\App\Http\Controllers\Assistant\ChargeController::class, 'index'])->name('charges.index');
    Route::get('/charges/ajouter', [\App\Http\Controllers\Assistant\ChargeController::class, 'create'])->name('charges.ajouter');
    Route::post('/charges', [\App\Http\Controllers\Assistant\ChargeController::class, 'store'])->name('charges.store');
    Route::get('/charges/{charge}/edit', [\App\Http\Controllers\Assistant\ChargeController::class, 'edit'])->name('charges.edit');
    Route::put('/charges/{charge}', [\App\Http\Controllers\Assistant\ChargeController::class, 'update'])->name('charges.update');
    Route::delete('/charges/{charge}', [\App\Http\Controllers\Assistant\ChargeController::class, 'destroy'])->name('charges.destroy');
    Route::get('/charges/{charge}', [\App\Http\Controllers\Assistant\ChargeController::class, 'show'])->name('charges.show');

    // Paiements
    Route::get('/paiements', [\App\Http\Controllers\PaiementController::class, 'index'])->name('paiements.index');
    Route::get('/paiements/historique', [\App\Http\Controllers\PaiementController::class, 'historique'])->name('paiements.historique');
    Route::post('/paiements', [\App\Http\Controllers\PaiementController::class, 'store'])->name('paiements.store');
    Route::get('/paiements/{id}/facture', [\App\Http\Controllers\PaiementController::class, 'facture'])->name('paiements.facture');
    Route::delete('/paiements/{id}', [\App\Http\Controllers\PaiementController::class, 'destroy'])->name('paiements.destroy');

    // Immeubles (view only)
    Route::get('/immeubles', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'index'])->name('immeubles.index');
    Route::get('/immeubles/{id}/cotisation', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'getCotisation'])->name('immeubles.cotisation');
    Route::get('/immeubles/{id}', [\App\Http\Controllers\Assistant\ImmeubleController::class, 'show'])->name('immeubles.show');

    // Résidences (view only)
    Route::get('/residences', [\App\Http\Controllers\Assistant\ResidenceController::class, 'index'])->name('residences');
    Route::get('/residences/{id}/info', [\App\Http\Controllers\Assistant\ResidenceController::class, 'getInfo'])->name('residences.info');

    // Appartements (view only)
    Route::get('/appartements', [\App\Http\Controllers\Assistant\AppartementController::class, 'index'])->name('appartements.index');
    Route::get('/appartements/{id}', [\App\Http\Controllers\Assistant\AppartementController::class, 'show'])->name('appartements.show');
});
