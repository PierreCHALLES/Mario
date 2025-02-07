<?php
use App\Http\Controllers\TopRentalsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\FilmController; // Import du contrôleur des films
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionStockController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mario', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//Route pour ajouter un film
Route::get('/films/add', function () {
    return view('addFilm');
});
Route::post('/films', [FilmController::class, 'addFilm']);


// Routes pour les films
Route::get('/films', [FilmController::class, 'index'])->name('films.index')->middleware(['auth', 'verified']);
Route::get('/films/create', [FilmController::class, 'create'])->name('films.create')->middleware(['auth', 'verified']); // Ajouter un film
Route::post('/films', [FilmController::class, 'store'])->name('films.store')->middleware(['auth', 'verified']); // Sauvegarder un film
Route::get('/films/{filmId}/edit', [FilmController::class, 'edit'])->name('films.edit')->middleware(['auth', 'verified']); // Modifier un film
Route::put('/films/{filmId}', [FilmController::class, 'update'])->name('films.update')->middleware(['auth', 'verified']); // Mettre à jour un film
Route::delete('/films/{id}', [FilmController::class, 'deleteFilm'])->name('films.destroy')->middleware(['auth', 'verified']); // Supprimer un film
Route::get('/films/details/{filmId}', [FilmController::class, 'details'])->name('films.details');
Route::get('/top-rentals', [TopRentalsController::class, 'index'])->name('top.rentals');
Route::get('gestionDesStocks', [GestionStockController::class, 'index'])->name('Gestion.Stock');
require __DIR__.'/auth.php';
