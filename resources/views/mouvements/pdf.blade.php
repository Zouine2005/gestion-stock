<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mouvements PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        th {
            background: #f0f0f0;
        }
        .header {
            text-align: center;
        }
        .header img {
            height: 80px;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo_est_ouarzazate.jpg') }}" alt="Logo EST Ouarzazate"> <br>
        <h2 style="text-align: center;">
            {{ $produit ? 'Historique des mouvements du produit : ' . $produit->designation : 'Liste des Mouvements (Tous les Produits)' }}
        </h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Numero_inventaire</th>
                <th>Produit</th>
                <th>Type</th>
                <th>Quantité</th>
                <th>Date</th>
                <th>Motif</th>
                <th>Destination</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mouvements as $mouvement)
                <tr>
                    <td>{{ $mouvement->produit->numero_inventaire ?? '-' }}</td>
                    <td>{{ $mouvement->produit->designation ?? '-' }}</td>
                    <td>{{ ucfirst($mouvement->type) }}</td>
                    <td>{{ $mouvement->quantite }}</td>
                    <td>{{ \Carbon\Carbon::parse($mouvement->date_mouvement)->format('d/m/Y') }}</td>
                    <td>{{ $mouvement->motif ?? '-' }}</td>
                    <td>{{ $mouvement->destination ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
