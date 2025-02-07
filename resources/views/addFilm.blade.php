<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Film</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1 class="text-center">Ajouter un Film</h1>
        <form action="{{ url('/films') }}" method="POST" class="mt-4">
            @csrf <!-- Token de sécurité -->

            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" required maxlength="255">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required maxlength="1000"></textarea>
            </div>

            <div class="mb-3">
                <label for="releaseYear" class="form-label">Année de sortie</label>
                <input type="number" class="form-control" id="releaseYear" name="releaseYear" required min="1900" max="{{ date('Y') }}">
            </div>

            <div class="mb-3">
                <label for="languageId" class="form-label">Langue</label>
                <input type="number" class="form-control" id="languageId" name="languageId" required>
            </div>

            <div class="mb-3">
                <label for="originalLanguageId" class="form-label">Langue originale</label>
                <input type="number" class="form-control" id="originalLanguageId" name="originalLanguageId">
            </div>

            <div class="mb-3">
                <label for="rentalDuration" class="form-label">Durée de location</label>
                <input type="number" class="form-control" id="rentalDuration" name="rentalDuration" required>
            </div>

            <div class="mb-3">
                <label for="rentalRate" class="form-label">Tarif de location</label>
                <input type="number" step="0.01" class="form-control" id="rentalRate" name="rentalRate" required>
            </div>

            <div class="mb-3">
                <label for="length" class="form-label">Durée (en minutes)</label>
                <input type="number" class="form-control" id="length" name="length" required>
            </div>

            <div class="mb-3">
                <label for="replacementCost" class="form-label">Coût de remplacement</label>
                <input type="number" step="0.01" class="form-control" id="replacementCost" name="replacementCost" required>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Classification</label>
                <input type="text" class="form-control" id="rating" name="rating" required maxlength="10">
            </div>

            <div class="mb-3">
                <label for="specialFeatures" class="form-label">Caractéristiques spéciales</label>
                <input type="text" class="form-control" id="specialFeatures" name="specialFeatures">
            </div>

            <div class="mb-3">
                <label for="lastUpdate" class="form-label">Dernière mise à jour</label>
                <input type="datetime-local" class="form-control" id="lastUpdate" name="lastUpdate" required>
            </div>

            <div class="mb-3">
                <label for="idDirector" class="form-label">Réalisateur (ID)</label>
                <input type="number" class="form-control" id="idDirector" name="idDirector" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Ajouter le Film</button>
        </form>
    </div>
</body>
</html>
