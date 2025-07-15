<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Affectations</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h2>Liste des Affectations</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($affectations as $affectation)
                <tr>
                    <td>{{ $affectation->nom }}</td>
                    <td>{{ $affectation->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
