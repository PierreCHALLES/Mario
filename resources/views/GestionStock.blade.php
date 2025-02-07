<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Gestion des Stocks</h1>

        @if(isset($inventoryData) && $inventoryData->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-300">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Quantity</th>
                            <th class="px-4 py-2">Address</th>
                            <th class="px-4 py-2">District</th>
                            <th class="px-4 py-2">Film ID</th>
                            <th class="px-4 py-2">Store ID</th>
                            <th class="px-4 py-2">Address ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventoryData as $item)
                            <tr class="border-t border-gray-300">
                                <td class="px-4 py-2 text-center">{{ $item['title'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $item['quantity'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $item['address'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $item['district'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $item['filmId'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $item['storeId'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $item['addressId'] }}</td>
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
