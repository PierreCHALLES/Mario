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
        <form action="{{ route('films.store') }}" method="POST" class="mt-4">
    @csrf <!-- Token de sécurité obligatoire -->


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


            <button type="submit" class="btn btn-primary w-100">Ajouter le Film</button>
        </form>
    </div>
</body>
</html>
