<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des Produits</title>
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
        <h2>Liste des Produits </h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Numéro_Inventaire</th>
                <th>Désignation</th>
                <th>Quantité Stock</th>
                <th>Unité</th>
                <th>Société</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produits as $produit)
                <tr>
                    <td>{{ $produit->numero_inventaire }}</td>
                    <td>{{ $produit->designation }}</td>
                    <td>{{ $produit->quantite_stock }}</td>
                    <td>{{ $produit->unite }}</td>
                    <td>{{ $produit->societe->nom ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
