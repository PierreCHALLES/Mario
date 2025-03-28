<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Modifier le Film</h1>

        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6">
            <form action="{{ route('films.update', $film['filmId']) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Champs cachés pour les données non modifiables -->
                <input type="hidden" name="languageId" value="{{ old('languageId', $film['languageId']) }}">
                <input type="hidden" name="originalLanguageId" value="{{ old('originalLanguageId', $film['originalLanguageId']) }}">
                <input type="hidden" name="rentalDuration" value="{{ old('rentalDuration', $film['rentalDuration']) }}">
                <input type="hidden" name="rentalRate" value="{{ old('rentalRate', $film['rentalRate']) }}">
                <input type="hidden" name="length" value="{{ old('length', $film['length']) }}">
                <input type="hidden" name="rating" value="{{ old('rating', $film['rating']) }}">

                <!-- Titre -->
                <div class="mb-4">
                    <label for="title" class="text-lg font-medium text-gray-600">Titre :</label>
                    <input type="text" name="title" id="title" class="w-full p-2 border border-gray-300 rounded" value="{{ old('title', $film['title']) }}" required>
                    @error('title')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="text-lg font-medium text-gray-600">Description :</label>
                    <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded" rows="4" required>{{ old('description', $film['description']) }}</textarea>
                    @error('description')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Année de sortie -->
                <div class="mb-4">
                    <label for="releaseYear" class="text-lg font-medium text-gray-600">Année de sortie :</label>
                    <input type="number" name="releaseYear" id="releaseYear" class="w-full p-2 border border-gray-300 rounded" value="{{ old('releaseYear', $film['releaseYear']) }}" required>
                    @error('releaseYear')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Coût de remplacement -->
                <div class="mb-4">
                    <label for="replacementCost" class="text-lg font-medium text-gray-600">Coût de remplacement :</label>
                    <input type="number" step="0.01" name="replacementCost" id="replacementCost" class="w-full p-2 border border-gray-300 rounded" value="{{ old('replacementCost', $film['replacementCost']) }}" required>
                    @error('replacementCost')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                
                <!-- Dernière mise à jour -->
                <div class="mb-4">
                    <label for="lastUpdate" class="text-lg font-medium text-gray-600">Dernière mise à jour :</label>
                    <input type="datetime-local" name="lastUpdate" id="lastUpdate" class="w-full p-2 border border-gray-300 rounded" value="{{ old('lastUpdate', $film['lastUpdate']) }}">
                </div>

                <!-- Fonctionnalités spéciales -->
                <div class="mb-4">
                    <label for="specialFeatures" class="text-lg font-medium text-gray-600">Fonctionnalités spéciales :</label>
                    <input type="text" name="specialFeatures" id="specialFeatures" class="w-full p-2 border border-gray-300 rounded" value="{{ old('specialFeatures', $film['specialFeatures']) }}">
                </div>

                <!-- Bouton Sauvegarder -->
                <div class="mt-6 text-center">
                    <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded">
                        Sauvegarder les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
