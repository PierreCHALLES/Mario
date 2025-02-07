<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 10 des Locations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Top 10 des Films les Plus Loués</h1>
    <table>
        <thead>
            <tr>
                <th>Classement</th>
                <th>Film</th>
                <th>Nombre de Locations</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topRentals as $index => $rental)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rental->title }}</td>
                    <td>{{ $rental->total_rentals }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
