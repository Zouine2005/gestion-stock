<?php



namespace App\Exports;

use App\Models\Produit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProduitsExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    public function collection()
    {
        return Produit::with('societe')->get()->map(function ($produit) {
            return [
                $produit->numero_inventaire,
                $produit->designation,
                $produit->quantite_stock,
                $produit->unite,
                $produit->societe->nom ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['Numéro Inventaire', 'Désignation', 'Quantité Stock', 'Unité', 'Société'];
    }

    public function styles(Worksheet $sheet)
    {
        // Mettre les entêtes en gras
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $rowCount = Produit::count() + 1; // 1 ligne pour les entêtes
                $cellRange = 'A1:E' . $rowCount;

                // Appliquer les bordures fines à toutes les cellules du tableau
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
