<?php

namespace App\Http\Controllers;

use App\Models\Certificacion;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CertificadosExport;

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


    // Generar dictamen (ejemplo: descargar PDF o generar reporte)
    public function generarDictamen()
    {
        // Aquí implementa la lógica para generar dictamen
        // Ejemplo: retornar un PDF o mensaje
        return redirect()->back()->with('success', 'Dictamen generado correctamente.');
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

    return response()->json(['message' => 'Certificado rechazado correctamente.']);
}

}
