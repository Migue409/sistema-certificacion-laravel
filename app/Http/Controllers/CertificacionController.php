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

public function aprobar($id, $accion)
{
    $certificado = Certificacion::where('id_usuario', $id)->first();

    if (!$certificado) {
        return response()->json(['message' => 'Certificado no encontrado'], 404);
    }

    $certificado->estatus = $accion === 'validar' ? 'Aprobado' : 'Rechazado';
    $certificado->save();

    return response()->json(['message' => "El certificado ha sido {$certificado->estatus}."]);
}

public function generarDictamen($id_usuario)
{
    $certificado = Certificacion::where('id_usuario', $id_usuario)->firstOrFail();

    if ($certificado->estatus !== 'Aprobado' && $certificado->estatus !== 'Aprobado') {
        abort(403, 'El dictamen solo puede generarse para estudiantes aprobados.');
    }

    $pdf = Pdf::loadView('ActExt.administrador.dictamen', [
        'certificado' => $certificado
    ]);

    return $pdf->download('Dictamen_'.$certificado->matricula.'.pdf');
}

}
