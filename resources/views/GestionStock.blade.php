<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Gestion des Stocks</h1>

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('gestionStock.index') }}" class="mb-6">
            <div class="flex justify-center items-center space-x-4">
                <input type="text" name="search" placeholder="Rechercher par titre..." value="{{ request('search') }}" class="px-4 py-2 border border-gray-300 rounded-md" />
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Rechercher</button>
            </div>
        </form>

        @if(isset($inventoryData) && $inventoryData->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-300">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Films Disponibles</th>
                            <th class="px-4 py-2">Total Stock</th>
                            <th class="px-4 py-2">Films Loués</th>
                            <th class="px-4 py-2">Address</th>
                            <th class="px-4 py-2">District</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventoryData as $item)
                            <tr class="border-t border-gray-300">
                                <td class="px-4 py-2 text-center">{{ $item['title'] }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if($item['filmsDisponibles'] == 'Non disponible')
                                        <span class="text-red-500">{{ $item['filmsDisponibles'] }}</span>
                                    @else
                                        <span class="text-green-500">{{ $item['filmsDisponibles'] }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">{{ $item['totalStock'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $item['totalLoues'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $item['address'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $item['district'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-6 flex justify-center">
                {{ $inventoryData->links() }}
            </div>
        @else
            <p class="text-red-500 text-center">Aucun stock trouvé.</p>
        @endif
    </div>
</x-app-layout>
