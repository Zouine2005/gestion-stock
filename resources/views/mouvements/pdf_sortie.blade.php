<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des Mouvements</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; }
        .header img { height: 80px; margin-bottom: 6px; }
        h1 { color: #333; }
        h2 { color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f0f0f0; }
        .emargement { text-align: center; margin-top: 20px; }
        .emargement table { margin: 0 auto; }
        .emargement th, .emargement td { border-collapse: collapse: ; padding: 10px; }
        .footer { text-align: center; margin-top: 20px; }
        .emargement-title {
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
            color: black;
        }
    </style>
</head>
<body>
    <!-- En-tête avec logo et titre -->
    <div class="header">
        <img src="{{ public_path('images/logo_est_ouarzazate.jpg') }}" alt="Logo EST Ouarzazate">
        <h1>Historique des Mouvements</h1>
        @if(isset($produit))
            <h2>Produit: {{ $produit->designation }}</h2>
        @endif
    </div>

    <!-- Tableau des mouvements -->
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
                    <td>{{ $mouvement->produit ? $mouvement->produit->numero_inventaire : '-' }}</td>
                    <td>{{ $mouvement->produit ? $mouvement->produit->designation : '-' }}</td>
                    <td>{{ ucfirst($mouvement->type) }}</td>
                    <td>{{ $mouvement->quantite }}</td>
                    <td>{{ \Carbon\Carbon::parse($mouvement->date_mouvement)->format('d/m/Y') }}</td>
                    <td>{{ $mouvement->motif ?? '-' }}</td>
                    <td>{{ $mouvement->destination ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

     <h2 class="emargement-title">Emargement</h2>
    <!-- Section Emargement -->
    <div class="emargement">
       
        <table>
            <thead>
                <tr>
                    <th style="width: 33%;">Le Demandeur</th>
                    <th style="width: 33%;">Le Doyen</th>
                    <th style="width: 33%;">Magasinier</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="height: 50px;"></td>
                    <td style="height: 50px;"></td>
                    <td style="height: 50px;"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <p>Généré le {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
    </div>
</body>
</html>