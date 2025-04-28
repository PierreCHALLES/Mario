<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Détails du Film</h1>

        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6">
            <!-- Titre -->
            <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">{{ $film['title'] }}</h2>

            <!-- Description -->
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-600">Description :</h3>
                <p class="text-gray-700">{{ $film['description'] }}</p>
            </div>

            <!-- Année de sortie -->
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-600">Année de sortie :</h3>
                <p class="text-gray-700">{{ $film['releaseYear'] }}</p>
            </div>


            <!-- Fonctionnalités spéciales -->
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-600">Fonctionnalités spéciales :</h3>
                <p class="text-gray-700">{{ $film['specialFeatures'] }}</p>
            </div>

            <!-- Dernière mise à jour -->
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-600">Dernière mise à jour :</h3>
                <p class="text-gray-700">{{ $film['lastUpdate'] }}</p>
            </div>

            <!-- Bouton Retour -->
            <div class="mt-6 text-center">
                <a href="{{ route('films.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Retour au catalogue
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
