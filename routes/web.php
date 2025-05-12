<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AjouterFilmController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GestionStockController;
use App\Http\Controllers\TopRentalsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Connexion staff
Route::view('/', 'login_staff')->name('login.form');
Route::post('/login_staff', [LoginController::class, 'login'])->name('login_staff');

// Dashboard
Route::view('/mario', 'dashboard')->name('dashboard');

// Profil utilisateur
Route::get('/profile',    [ProfileController::class, 'edit']   )->name('profile.edit');
Route::patch('/profile',  [ProfileController::class, 'update'] )->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// CRUD Films
Route::get('/films',                  [FilmController::class, 'index']     )->name('films.index');
Route::get('/films/create',           [AjouterFilmController::class, 'create'])->name('films.create');
Route::post('/films',                 [AjouterFilmController::class, 'store'] )->name('films.store');
Route::get('/films/{filmId}/edit',    [FilmController::class, 'edit']      )->name('films.edit');
Route::put('/films/{filmId}',         [FilmController::class, 'update']    )->name('films.update');
Route::delete('/films/{filmId}',      [FilmController::class, 'deleteFilm'])->name('films.destroy');
Route::get('/films/details/{filmId}', [FilmController::class, 'details']   )->name('films.details');

// Ajout d’inventaire
Route::get('/ajouter-inventaire', [AjouterFilmController::class, 'crees'])->name('inventory.create');
Route::post('/ajouter-inventaire',[AjouterFilmController::class, 'Ajout'])->name('inventory.store');

// Gestion des stocks
Route::get('/gestionStocks', [GestionStockController::class, 'index'])
     ->name('gestionStock.index');

// Suppression d’un film dans l’inventaire
Route::delete('/gestionStocks/{filmId}', [GestionStockController::class, 'destroy'])
     ->name('inventory.destroy');

// Top Rentals
Route::get('/top-rentals', [TopRentalsController::class, 'index'])->name('top.rentals');
