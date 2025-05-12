<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        // Récupérer les données soumises
        $data = $request->all();
        
        // Définir les valeurs par défaut
        $valeursParDefaut = [
            'languageId' => 1,
            'originalLanguageId' => 1,
            'rentalRate' => 0.99,
            'replacementCost' => 1.99,
            'rentalDuration' => 6,
            'length' => 120,
            'rentalDuration' => 5,
            'rating' => 'PG',
            'special_Features' => "nouvelle_sortie",
            'lastUpdate' => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        // Fusionner les valeurs soumises avec les valeurs par défaut
        $data = array_merge($data, $valeursParDefaut);

        // Construction de l'URL du service API
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $endpointAddFilm = '/toad/film/add';

        // Envoi de la requête HTTP POST à l'API
        $response = Http::asForm()->post($adress . $port . $endpointAddFilm, $data);

        // Vérification si la requête a réussi
        if ($response->successful()) {
            return redirect()->route('films.index')->with('success', 'Film ajouté avec succès !');
        } else {
            // Gestion des erreurs si l'API répond avec un statut d'erreur
            return redirect()->route('films.index')->with('error', 'Erreur lors de l\'ajout du film. Veuillez réessayer.');
        }
    }

    public function Ajout(Request $request)
{
    // Vérifie que les champs sont bien présents
    $validated = $request->validate([
        'film_id' => 'required|integer',
        'store_id' => 'required|integer',
    ]);

    // Données à envoyer
    $data = [
        'film_id' => $request->film_id,
        'store_id' => $request->store_id,
        'quantite' => $request->quantite,
        'existe' => true,
        'last_update' => now()->format('Y-m-d H:i:s'),
        
    ];

    // Adresse de l'API Java
    $adress = env('TOAD_SERVER');
    $port = env('TOAD_PORT');
    $endpointAddInventory = '/toad/inventory/add';

    // Appel à l'API Java
    $response = Http::asForm()->post($adress . $port . $endpointAddInventory, $data);

    // Gestion du retour
    if ($response->successful()) {
        return redirect()->back()->with('success', 'Inventaire ajouté avec succès !');
    } else {
        return redirect()->back()->with('error', 'Échec de l\'ajout de l\'inventaire.');
    }
  }
  public function crees()
{
    // Appel API pour récupérer tous les films
    $response = Http::get(env('TOAD_SERVER') . env('TOAD_PORT') . '/toad/film/all');

    // Vérifie si l'API a répondu correctement
    if ($response->successful()) {
        $films = $response->json();
    } else {
        $films = []; // vide si échec
    }

    // Affiche la vue avec la liste des films
    return view('AjoutInventaire', ['films' => $films]);
}



}

