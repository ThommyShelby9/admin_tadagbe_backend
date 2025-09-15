<?php

namespace App\Exports;

use App\Models\Student;
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

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::with(['user', 'school'])->get();
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
            'Téléphone',
            'Email',
            'École',
            'Niveau d\'étude',
            'Nom utilisateur Moodle',
            'Statut',
            'Date d\'inscription',
        ];
    }

    /**
     * Personnaliser les données pour chaque ligne
     */
    public function map($student): array
    {
        // Obtenir le statut
        $statusLabels = [
            0 => 'Inactif',
            1 => 'Actif',
            // Ajoutez d'autres statuts au besoin
        ];

        $status = $statusLabels[$student->status] ?? 'Inconnu';

        return [
            $student->id,
            $student->user ? $student->user->last_name : 'N/A',
            $student->user ? $student->user->first_name : 'N/A',
            $student->user ? $student->user->phone : 'N/A',
            $student->user ? $student->user->email : 'N/A',
            $student->school ? $student->school->name : 'N/A',
            $student->study_level,
            $student->moodle_user_name,
            $status,
            $student->created_at->format('d/m/Y'),
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
                'startColor' => ['rgb' => '3498DB'], // Bleu vif
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
                        'startColor' => ['rgb' => 'EBF5FB'], // Bleu très clair
                    ],
                ]);
            }
        }

        // Coloration conditionnelle basée sur le statut (colonne I)
        foreach ($sheet->getRowIterator(2) as $row) {
            $statusCell = 'I' . $row->getRowIndex();
            $statusValue = $sheet->getCell($statusCell)->getValue();

            switch ($statusValue) {
                case 'Actif':
                    $color = '28A745'; // Vert
                    break;
                case 'Inactif':
                    $color = 'DC3545'; // Rouge
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
        return 'Liste des étudiants';
    }
}
