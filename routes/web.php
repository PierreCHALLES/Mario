<?php
use App\Http\Controllers\TopRentalsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestionStockController;
use App\Http\Controllers\AjouterFilmController;
use App\Http\Controllers\LoginController;
/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', function () {
    return view('login_staff');
});
Route::post('/login_staff', [LoginController::class, 'login'])->name('login_staff');

Route::get('/mario', function () {
    return view('dashboard');
})->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//Route pour ajouter un film
Route::get('/films/create', [AjouterFilmController::class, 'create'])->name('films.create');
Route::post('/films', [AjouterFilmController::class, 'store'])->name('films.store');


// Route pour afficher le formulaire (GET)
Route::get('/ajouter-inventaire', [AjouterFilmController::class, 'crees'])->name('ajouter.inventory');

// Route pour traiter l'ajout (POST)
Route::post('/ajouter-inventaire', [AjouterFilmController::class, 'Ajout']);

// Routes pour les films
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
//Route::post('/films', [FilmController::class, 'store'])->name('films.store')->middleware(['auth', 'verified']); // Sauvegarder un film
Route::get('/films/{filmId}/edit', [FilmController::class, 'edit'])->name('films.edit');
Route::put('/films/{filmId}', [FilmController::class, 'update'])->name('films.update');
Route::delete('/films/{id}', [FilmController::class, 'deleteFilm'])->name('films.destroy');
Route::get('/films/details/{filmId}', [FilmController::class, 'details'])->name('films.details');
Route::get('/top-rentals', [TopRentalsController::class, 'index'])->name('top.rentals');
Route::get('/gestionDesStocks', [GestionStockController::class, 'index'])->name('Gestion.Stock');
Route::get('/gestionStocks', [GestionStockController::class, 'index'])->name('gestionStock.index');
//require __DIR__.'/auth.php';
