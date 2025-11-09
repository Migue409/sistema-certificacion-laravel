<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\DatosAcademicos;

class CertificacionEstudianteController extends Controller
{
    public function index()
    {
        $certificacion = Certificacion::where('id_usuario', Auth::id())->first();
        return view('ActExt.estudiantes.certificacionEST', compact('certificacion'));

    }

    public function store(Request $request)
{
    $request->validate([
        'puntaje' => 'required|numeric|min:0',
        'nivel_in' => 'required|string|max:3',
        'certificado' => 'required|string|max:255',
        'archivo' => 'required|mimes:pdf|max:5120',
    ]);

    $archivoPath = $request->file('archivo')->store('certificados', 'public');

    // Obtener los datos académicos del usuario
    $datosAcademicos = DatosAcademicos::where('id_usuario', Auth::id())->first();

    if (!$datosAcademicos) {
        return back()->withErrors(['msg' => 'No se encontraron datos académicos para este usuario.']);
    }

    Certificacion::updateOrCreate(
        ['id_usuario' => Auth::id()],
        [
            'nombre' => Auth::user()->nombre, 
            'matricula' => Auth::user()->matricula,
            'correo' => Auth::user()->correo,
            'division' => $datosAcademicos->division,
            'grupo_ingles' => $datosAcademicos->grupo_ingles,
            'nivel_in' => $request->nivel_in,
            'certificado' => $request->certificado,
            'puntaje' => $request->puntaje,
            'archivo' => $archivoPath,
            'estatus' => 'Pendiente',
        ]
    );



        return redirect()->route('estudiantes.certificacionEST')->with('success', 'Certificado registrado correctamente.');

    }
}
