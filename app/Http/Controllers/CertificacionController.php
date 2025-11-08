<?php

namespace App\Http\Controllers;

use App\Models\Certificacion;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CertificadosExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificacionController extends Controller
{
    // Mostrar la lista de certificados
    public function index()
    {
        $certificados = Certificacion::all();
        return view('ActExt.administrador.certificacion', compact('certificados'));
    }

    // Exportar certificados a Excel
    public function exportarExcel()
{
    return Excel::download(new CertificadosExport, 'certificados.xlsx');
}

    public function validar($id)
{
    $cert = Certificacion::findOrFail($id);

    $certificadosValidos = ['PET', 'FCE', 'OTE', 'IELTS', 'TOEFL', 'TOEIC', 'CENNI', 'ISE', 'LINGUASKILL'];
    $nombreCert = strtoupper($cert->certificado);

    foreach ($certificadosValidos as $valido) {
        if (str_contains($nombreCert, $valido)) {
            $cert->estatus = 'Aprobado';
            $cert->save();
            return response()->json(['message' => 'Certificado validado y aprobado.']);
        }
    }

    $cert->estatus = 'Rechazado';
    $cert->save();
    return response()->json(['message' => 'Certificado rechazado.']);
}

public function rechazar($id)
{
    $cert = Certificacion::findOrFail($id);
    $cert->estatus = 'Rechazado';
    $cert->save();

    return response()->json(['message' => 'Certificado rechazado.']);
}

public function aprobar($id)
{
    $certificacion = Certificacion::findOrFail($id);
    $certificacion->estatus = 'Aprobado';
    $certificacion->save();

    // Generar PDF automáticamente
    $pdf = Pdf::loadView('ActExt.administrador.dictamen', compact('certificacion'));

    // Retornar el PDF como descarga inmediata
    return $pdf->download('Dictamen_' . $certificacion->matricula . '.pdf');

    // Guardar en almacenamiento interno (storage/app/public/dictamenes)
    Storage::disk('public')->put('dictamenes/' . $fileName, $pdf->output());

    // Retornar descarga inmediata al administrador
    return $pdf->download($fileName);
}

}
