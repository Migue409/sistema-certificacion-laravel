<?php

namespace App\Exports;

use App\Models\Certificacion;
use Maatwebsite\Excel\Concerns\FromCollection;

class CertificadosExport implements FromCollection
{
 public function collection()
    {
        return Certificacion::select(
        'id_usuario', 
        'nombre', 
        'matricula', 
        'correo', 
        'division', 
        'grupo_ingles', 
        'nivel_in', 
        'certificado', 
        'estatus',
        )->get();
    }

    public function headings(): array
    {
        return [
            'id_usuario',
            'nombre',
            'matricula',
            'correo',
            'division',
            'grupo_ingles',
            'nivel_in',
            'certificado',
            'estatus',
        ];
    }
     
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Encabezados en negrita
        ];
    }
}
