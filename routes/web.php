<?php

use Illuminate\Support\Facades\Route;

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
