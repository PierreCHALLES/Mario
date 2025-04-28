<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class GestionStockController extends Controller
{
    /**
     * Affiche les stocks avec pagination.
     */
    public function index(Request $request)
    {
        // Construction dynamique de l'URL
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $baseUrl = rtrim($adress, '/') . $port;
        
        $stockUrl = "$baseUrl/toad/inventory/getStockByStore";
        $filmsStockUrl = "$baseUrl/toad/inventory/stockFilm";
        
        // Appel aux API
        $stockResponse = Http::get($stockUrl);
        $filmsStockResponse = Http::get($filmsStockUrl);
        
        // Vérifie si les deux requêtes sont réussies
        if ($stockResponse->successful() && $filmsStockResponse->successful()) {
            $stockData = collect($stockResponse->json());
            $filmsStockData = collect($filmsStockResponse->json());
            
            // Recherche par titre si un terme est fourni
            $search = $request->query('search', '');
            if (!empty($search)) {
                $stockData = $stockData->filter(fn($item) => stripos($item['title'], $search) !== false);
            }
            
            // Associer les stocks de films aux stocks par magasin
            $mergedData = $stockData->map(function ($item) use ($filmsStockData) {
                $filmStock = $filmsStockData->firstWhere('title', $item['title']);
                
                return [
                    'title' => $item['title'],
                    'filmsDisponibles' => $filmStock['filmsDisponibles'] ?? 'Non disponible',
                    'totalStock' => $filmStock['totalStock'] ?? 'N/A',
                    'totalLoues' => $filmStock['totalLoues'] ?? 'N/A',
                    'district' => $item['district'],
                    'address' => $item['address'],
                ];
            });
            
            // Pagination
            $perPage = 10;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $mergedData->slice(($currentPage - 1) * $perPage, $perPage)->values();
            
            // Crée une instance de LengthAwarePaginator
            $paginatedInventory = new LengthAwarePaginator(
                $currentPageItems,
                $mergedData->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
            // Retourne les données à la vue
            return view('gestionStock', ['inventoryData' => $paginatedInventory]);
        }
        
        // Gestion des erreurs si l'une des API échoue
        return redirect()->back()->withErrors('Impossible de récupérer les stocks.');
    }
}