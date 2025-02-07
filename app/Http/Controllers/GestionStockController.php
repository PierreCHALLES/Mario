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
        // URL du webservice
        $apiUrl = 'http://localhost:8080/toad/inventory/getStockByStore';

        // Appel au webservice pour récupérer les stocks
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            // Transforme les données JSON en une collection
            $inventoryData = collect($response->json())->map(function ($item) {
                return [
                    'title' => $item['title'],
                    'quantity' => $item['quantity'],
                    'district' => $item['district'],
                    'address' => $item['address'],
                    'filmId' => $item['filmId'],
                    'storeId' => $item['storeId'],
                    'addressId' => $item['addressId']
                ];
            });

            // Nombre d'éléments par page
            $perPage = 10;

            // Page actuelle
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            // Extraire les éléments pour la page actuelle
            $currentPageItems = $inventoryData->slice(($currentPage - 1) * $perPage, $perPage)->values();

            // Crée une instance de LengthAwarePaginator
            $paginatedInventory = new LengthAwarePaginator(
                $currentPageItems,
                $inventoryData->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            // Retourne les données à la vue
            return view('gestionStock', [
                'inventoryData' => $paginatedInventory
            ]);
        }
    }
}
