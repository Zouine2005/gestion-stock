<?php

namespace App\Exports;

use App\Models\Mouvement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MouvementsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Mouvement::with('produit')->get()->map(function ($m) {
            return [
                'Produit' => $m->produit->designation ?? '-',
                'Type' => ucfirst($m->type),
                'Quantité' => $m->quantite,
                'Date' => \Carbon\Carbon::parse($m->date_mouvement)->format('d/m/Y'),
                'Motif' => $m->motif ?? '-',
                'Destination' => $m->destination ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['Produit', 'Type', 'Quantité', 'Date', 'Motif', 'Destination'];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count() + 1; // +1 for header
        $cellRange = 'A1:F' . $rowCount;

        // Appliquer les bordures à toutes les cellules
        $sheet->getStyle($cellRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Optionnel : mettre le texte en gras pour l'en-tête
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        return [];
    }
}
