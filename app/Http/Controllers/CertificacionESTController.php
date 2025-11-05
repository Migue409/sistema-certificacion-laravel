<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificacionESTController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $certificaciones = Certificacion::where('id_usuario', $usuario->id)->get();

        return view('ActExt.estudiantes.certificacion', compact('certificaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'puntaje' => 'required|numeric|min:0|max:200',
            'nivel' => 'required|string',
            'tipo_certificacion' => 'required|string',
            'certificado_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $usuario = Auth::user();
        $archivo = $request->file('certificado_pdf');
        $nombreArchivo = time().'_'.$archivo->getClientOriginalName();
        $archivo->storeAs('certificados', $nombreArchivo, 'public');

        Certificacion::create([
            'nombre' => $usuario->nombre,
            'matricula' => $usuario->matricula,
            'grupo_ingles' => $usuario->grupo_ingles,
            'division' => $usuario->division,
            'nivel_in' => $request->nivel_in,
            'puntaje' => $request->puntaje,
            'certificacion' => $request->certificacion,
            'archivo' => $nombreArchivo,
            'estatus' => 'Pendiente',
            'id_usuario' => $usuario->id,
        ]);

        return redirect()->back()->with('success', 'Certificación registrada correctamente.');
    }
}
