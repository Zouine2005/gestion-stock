<?php
namespace App\Exports;

use App\Models\Societe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SocietesExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Societe::select('nom', 'adresse', 'telephone', 'email')->get();
    }

    public function headings(): array
    {
        return ['Nom', 'Adresse', 'Téléphone', 'Email'];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Appliquer les bordures et le style
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Titre en gras
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'argb' => 'D9E1F2',
                ],
            ],
        ]);

        return [];
    }
}
