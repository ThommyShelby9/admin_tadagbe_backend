<?php

namespace App\Exports;

use App\Models\Admission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AdmissionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Admission::all();
    }

    /**
     * Définir les en-têtes des colonnes
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Prénom',
            'Date de naissance',
            'Téléphone',
            'Email',
            'Nationalité',
            'Filière',
            'ID École',
            'ID Parcours d\'étude',
            'Mode de paiement',
            'Statut',
            'Date de création',
        ];
    }

    /**
     * Personnaliser les données pour chaque ligne
     */
    public function map($admission): array
    {
        return [
            $admission->id,
            $admission->last_name,
            $admission->first_name,
            $admission->birth_date,
            $admission->phone,
            $admission->email,
            $admission->nationality,
            $admission->study_branch_code,
            $admission->school_id, // Juste l'ID au lieu du nom
            $admission->study_path_id, // Juste l'ID au lieu du nom
            $admission->paiement_mode,
            $admission->getStatusString(),
            $admission->created_at->format('d/m/Y'),
        ];
    }

    /**
     * Personnaliser les styles de la feuille Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Style pour l'en-tête
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2C3E50'], // Bleu foncé
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Appliquer une hauteur plus grande à la première ligne (en-tête)
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Style pour toutes les cellules de données
        $sheet->getStyle('A2:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Style alterné pour les lignes (effet zébré)
        for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle('A' . $i . ':' . $sheet->getHighestColumn() . $i)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F0F5F9'], // Bleu très clair
                    ],
                ]);
            }
        }

        // Coloration conditionnelle basée sur le statut (colonne L)
        foreach ($sheet->getRowIterator(2) as $row) {
            $statusCell = 'L' . $row->getRowIndex();
            $statusValue = $sheet->getCell($statusCell)->getValue();

            switch ($statusValue) {
                case 'En attente':
                    $color = 'FFC107'; // Jaune
                    break;
                case 'A compléter':
                    $color = '17A2B8'; // Bleu
                    break;
                case 'En traitement':
                    $color = '6C757D'; // Gris
                    break;
                case 'Validée':
                    $color = '28A745'; // Vert
                    break;
                default:
                    $color = 'FFFFFF'; // Blanc
            }

            $sheet->getStyle($statusCell)->applyFromArray([
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ]);
        }

        return $sheet;
    }

    /**
     * Définir le titre de la feuille Excel
     */
    public function title(): string
    {
        return 'Liste des admissions';
    }
}
