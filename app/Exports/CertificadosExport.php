<?php

namespace App\Exports;

use App\Models\Certificacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class CertificadosExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    public function collection()
    {
        return Certificacion::select( 
            'nombre', 
            'matricula', 
            'correo', 
            'division', 
            'grupo_ingles', 
            'nivel_in', 
            'certificado', 
            'estatus'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Matrícula',
            'Correo',
            'División',
            'Grupo de inglés',
            'Nivel de inglés',
            'Certificado',
            'Estatus',
        ];
    }
     
    public function styles(Worksheet $sheet)
    {
        // Estilos para la fila 1 (encabezados)
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => Color::COLOR_WHITE],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF003366'], // Azul oscuro
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Ajustar ancho de columna automático para todas las columnas usadas (A a I)
                foreach (range('A', 'I') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
