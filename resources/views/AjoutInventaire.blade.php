<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un film à l'inventaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container">
    <h2 class="mb-4">Ajouter un film à l'inventaire</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('inventory.create') }}" method="POST" class="card p-4 shadow-sm bg-white">
        @csrf

        <div class="mb-3">
            <label for="search-film" class="form-label">Rechercher un film :</label>
            <input type="text" id="search-film" class="form-control" placeholder="Tapez un titre pour filtrer...">
        </div>

        <div class="mb-3">
            <label for="film_id" class="form-label">Titre du film :</label>
            <select name="film_id" id="film-select" class="form-select" required>
                @foreach ($films as $film)
                    <option value="{{ $film['filmId'] }}">{{ $film['title'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="store_id" class="form-label">Magasin :</label>
            <select name="store_id" class="form-select" required>
                <option value="1">Magasin 1</option>
                <option value="2">Magasin 2</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantite" class="form-label">Nombre d'exemplaires :</label>
            <input type="number" name="quantite" class="form-control" value="1" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter à l'inventaire</button>
    </form>
</div>

<script>
    const searchInput = document.getElementById('search-film');
    const select = document.getElementById('film-select');
    const options = Array.from(select.options);

    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        select.innerHTML = ''; // Réinitialiser

        options.forEach(option => {
            if (option.text.toLowerCase().includes(searchTerm)) {
                select.appendChild(option);
            }
        });
    });
</script>
</body>
</html>
