<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FilmController extends Controller
{
    /**
     * Retourne les films depuis une URL externe avec seulement le title et la description.
     */

     public function index(Request $request)
     {
         // Appelle l'API pour récupérer les films avec tous les champs
         $response = Http::get('http://localhost:8080/toad/film/all');
         
         if ($response->successful()) {
             // Transforme les données en une collection de films avec les informations nécessaires
             $films = collect($response->json())->map(function ($film) {
                 return [
                     'filmId' => $film['filmId'], // Ajoutez l'ID
                     'title' => $film['title'],
                     'description' => $film['description'],
                     'releaseYear' => $film['releaseYear'],
                 ];
             });
     
             // Nombre d'éléments par page
             $perPage = 10;
     
             // Page actuelle
             $currentPage = LengthAwarePaginator::resolveCurrentPage();
     
             // Extraire une sous-collection correspondant à la page actuelle
             $currentPageItems = $films->slice(($currentPage - 1) * $perPage, $perPage)->values();
     
             // Crée une instance de LengthAwarePaginator pour la pagination manuelle
             $paginatedFilms = new LengthAwarePaginator(
                 $currentPageItems,
                 $films->count(),
                 $perPage,
                 $currentPage,
                 ['path' => $request->url(), 'query' => $request->query()]
             );
     
             // Retourne la vue avec les films paginés
             return view('films.catalogue', ['films' => $paginatedFilms]);
         }
     
         // Redirige en cas d'échec
         return redirect()->back()->withErrors('Impossible de récupérer les films');
     }    

    public function all()
    {
        // Récupère les films depuis l'URL externe
        $response = Http::get('http://localhost:8080/toad/film/all');

        // Vérifie si la requête a réussi
        if ($response->successful()) {
            // Filtre les données pour ne garder que le title et la description
            $films = collect($response->json())->map(function ($film) {
                return [
                    'title' => $film['title'],
                    'description' => $film['description'],
                    'releaseYear' => $film['releaseYear'],
                ];
            });

            // Retourne les films en JSON avec seulement le title et la description
            return response()->json($films);
        }

        // Gère les erreurs si la requête échoue
        return response()->json(['error' => 'Impossible de récupérer les films'], 500);
    }
    public function edit($filmId)
    {
        // Récupérer les détails du film depuis l'API
        $response = Http::get("http://localhost:8080/toad/film/getById?id={$filmId}");

        if ($response->successful()) {
            // Retourne la vue pour afficher le formulaire de modification
            return view('films.edit', ['film' => $response->json()]);
        } else {
            // Si la récupération échoue, rediriger avec un message d'erreur
            return redirect()->route('films.index')->with('error', 'Film non trouvé.');
        }
    }

    // Méthode pour mettre à jour le film
    public function update(Request $request, $filmId)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'releaseYear' => 'required|integer|min:1900|max:' . date('Y'),
            'replacementCost' => 'required|numeric',
            'specialFeatures' => 'nullable|string',
            'lastUpdate' => 'required|date', 
        ]);

        // Envoie les données mises à jour à l'API
        $response = Http::put("http://localhost:8080/toad/film/update/{$filmId}", $validated);

        // Vérification de la réponse de l'API
        if ($response->successful()) {
            // Redirige avec un message de succès après la mise à jour du film
            return redirect()->route('films.index')
                             ->with('success', 'Film mis à jour avec succès.');
        } else {
            // Afficher un message d'erreur si l'API retourne une erreur
            return redirect()->route('films.index')->with('error', 'Échec de la mise à jour du film.');
        }
    }
    public function deleteFilm($id)
    {
        try {
            // Envoi de la requête DELETE à l'API backend
            $response = Http::delete("http://localhost:8080/toad/film/delete/{$id}");
     
            // Vérification de la réponse du backend
            if ($response->successful()) {
                return redirect('films')->with('success', 'Le film a été supprimé avec succès.');
            } else {
                return redirect()->back()->withErrors(['error' => 'Erreur lors de la suppression du film. Code : ' . $response->status()]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur de connexion au backend : ' . $e->getMessage()]);
        }
}
public function details($filmId)
{
    // Effectue une requête GET pour récupérer les détails du film depuis l'API externe
    $response = Http::get("http://localhost:8080/toad/film/getById?id={$filmId}");

    if ($response->successful()) {
        // Récupère les détails du film (en tant que tableau)
        $film = $response->json();

        // Retourne la vue pour afficher les détails du film
        return view('films.details', ['film' => $film]);
    }

    // En cas d'échec de la requête, vous pouvez gérer l'erreur ou rediriger
    return redirect()->route('films.index')->with('error', 'Le film n\'a pas pu être récupéré.');
}

public function create(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'releaseYear' => 'required|integer|min:1900|max:' . date('Y'),
            'languageId' => 'required|integer|max:30',
            'originalLanguageId' => 'nullable|integer',
            'rentalDuration' => 'required|integer',
            'rentalRate' => 'required|numeric',
            'length' => 'required|integer',
            'replacementCost' => 'required|numeric',
            'rating' => 'required|string|max:10',
            'specialFeatures' => 'nullable|string',
            'lastUpdate' => 'required|date',
            'idDirector' => 'required|integer|exists:directors,id', // Vérifie que le réalisateur existe
        ]);

        // Insertion dans la base de données
        DB::table('film')->insert([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'release_year' => $validated['releaseYear'],
            'language_id' => $validated['languageId'],
            'original_language_id' => $validated['originalLanguageId'] ?? null,
            'rental_duration' => $validated['rentalDuration'],
            'rental_rate' => $validated['rentalRate'],
            'length' => $validated['length'],
            'replacement_cost' => $validated['replacementCost'],
            'rating' => $validated['rating'],
            'special_features' => $validated['specialFeatures'] ?? null,
            'last_update' => $validated['lastUpdate'],
            'id_director' => $validated['idDirector'],
        ]);
        return view('addFilm', ['film' => $film]);
        // Retourner une réponse
        return response()->json(['message' => 'Film ajouté avec succès !'], 201);
    }

}