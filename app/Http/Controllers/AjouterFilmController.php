<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class AjouterFilmController extends Controller
{
    // Affiche le formulaire d'ajout d'un film
    public function create()
    {
        return view('create');
    }

    // Gère l'insertion d'un nouveau film
    public function store(Request $request)
    {
    $data = $request->all();
    $adress = env('TOAD_SERVER');
    $port = env('TOAD_PORT');
    $endpointAddFilm = '/toad/film/add';
    $servrequest = $adress.$port;
    $lastUpdate = Carbon::now()->format('Y-m-d H:i:s');
    $data['LastUpdate'] = $lastUpdate;
    $response = Http::asForm()->post($adress.$port.$endpointAddFilm,$data);

            // Vérification si la requête a réussi
            if ($response->successful()) {
                return redirect()->route('films.index')->with('success', 'Film ajouté avec succès !');
            } else {
                // Gestion des erreurs si l'API répond avec un statut d'erreur
                return redirect()->route('films.index')->with('error', 'Erreur lors de l\'ajout du film. Veuillez réessayer.');
            }
        } 
    }

