<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $endpoint = '/toad/film/all';
        $servrequest = rtrim($adress, '/') . $port;

        $data = $request->all();
        $data['LastUpdate'] = Carbon::now()->format('Y-m-d H:i:s');

        try {
            $response = Http::get($servrequest . $endpoint, $data);
            if ($response->successful()) {
                $films = collect($response->json());

                // Appliquer la recherche
                $search = $request->query('search', '');
                if (!empty($search)) {
                    $films = $films->filter(fn($film) => stripos($film['title'], $search) !== false);
                }

                // Pagination
                $perPage = 10;
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $currentPageItems = $films->slice(($currentPage - 1) * $perPage, $perPage)->values();

                $paginatedFilms = new LengthAwarePaginator(
                    $currentPageItems,
                    $films->count(),
                    $perPage,
                    $currentPage,
                    ['path' => $request->url(), 'query' => $request->query()]
                );

                return view('films.catalogue', ['films' => $paginatedFilms, 'search' => $search]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erreur de connexion au serveur : ' . $e->getMessage());
        }

        return redirect()->back()->withErrors('Impossible de récupérer les films.');
    }

    public function edit(Request $request, $filmId)
    {
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $endpoint = "/toad/film/getById?id=$filmId";
        $servrequest = rtrim($adress, '/') . $port;

        try {
            $response = Http::get($servrequest . $endpoint);
            if ($response->successful()) {
                return view('films.edit', ['film' => $response->json()]);
            }
        } catch (\Exception $e) {
            return redirect()->route('films.index')->withErrors('Erreur : ' . $e->getMessage());
        }

        return redirect()->route('films.index')->with('error', 'Film non trouvé.');
    }

    public function update(Request $request, $filmId)
    {
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $endpoint = "/toad/film/update/$filmId";
        $servrequest = rtrim($adress, '/') . $port;

        // Validation des données
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'releaseYear' => 'required|integer|min:1900|max:' . date('Y'),
            'replacementCost' => 'required|numeric',
            'specialFeatures' => 'nullable|string',
            'languageId' => 'required|integer',
            'originalLanguageId' => 'nullable|integer',
            'rentalDuration' => 'required|integer|min:1|max:100',
            'rentalRate' => 'required|numeric|min:0.1',
            'length' => 'nullable|integer|min:1',
            'rating' => 'nullable|string|max:10',
        ]);

        try {
            $response = Http::put($servrequest . $endpoint, $validated);
            if ($response->successful()) {
                return redirect()->route('films.index')->with('success', 'Film mis à jour avec succès.');
            }
        } catch (\Exception $e) {
            return redirect()->route('films.index')->withErrors('Erreur : ' . $e->getMessage());
        }

        return redirect()->route('films.index')->with('error', 'Échec de la mise à jour du film.');
    }

    public function deleteFilm(Request $request, $id)
    {
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $endpoint = "/toad/film/delete/$id";
        $servrequest = rtrim($adress, '/') . $port;

        try {
            $response = Http::delete($servrequest . $endpoint);
            if ($response->successful()) {
                return redirect('films')->with('success', 'Le film a été supprimé avec succès.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erreur de connexion : ' . $e->getMessage()]);
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la suppression du film.']);
    }

    public function details(Request $request, $filmId)
    {
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $endpoint = "/toad/film/getById?id=$filmId";
        $servrequest = rtrim($adress, '/') . $port;

        try {
            $response = Http::get($servrequest . $endpoint);
            if ($response->successful()) {
                return view('films.details', ['film' => $response->json()]);
            }
        } catch (\Exception $e) {
            return redirect()->route('films.index')->withErrors('Erreur : ' . $e->getMessage());
        }

        return redirect()->route('films.index')->with('error', 'Le film n\'a pas pu être récupéré.');
    }
}
