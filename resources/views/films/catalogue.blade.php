<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-6">Catalogue de Films</h1>
        <a href="{{ route('films.create', $filmId['filmId']) }}" class="bg-green-500 text-black px-4 py-2 rounded text-center">
                            Ajouter un Film
                        </a>
        <!-- Grille de films -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
            @foreach ($films as $film)
                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 flex flex-col justify-between h-56">
                    <!-- Image du film -->
<img 
    src="{{ asset('Image/ImageFilm.jpg') }}" 
    alt="Affiche de film" 
    style="width: 100px; height: 100px; object-fit: cover;" 
    class="rounded mb-2 mx-auto"
>
                    
                    <h2 class="text-xl font-semibold mb-2 text-center">{{ $film['title'] }}</h2>
                    
                    <!-- Boutons de contrôle -->
                    <div class="flex flex-col gap-2 mt-4">
                        <!-- Bouton Détails -->
                        <a href="{{ route('films.details', $film['filmId']) }}" class="bg-green-500 text-black px-4 py-2 rounded text-center">
                            Détails
                        </a>

                        <!-- Bouton Modifier -->
                        <a href="{{ route('films.edit', $film['filmId']) }}" class="bg-yellow-500 text-black px-4 py-2 rounded text-center">
                            Modifier
                        </a>

                        <!-- Bouton Supprimer -->
                        <form action="{{ route('films.destroy', $film['filmId']) }}" method="POST" class="text-center">
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="bg-red-500 text-black px-4 py-2 rounded"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce film ?')"
                            >
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $films->links() }}
        </div>
    </div>
</x-app-layout>
