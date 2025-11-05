<?php

namespace App\Http\Controllers;

use App\Models\Certificacion;
use Illuminate\Http\Request;

class CertificacionController extends Controller
{
    public function index() // Muestra la lista principal de certificados de lado del administrador
    {
        $certificados = Certificacion::all();
        return view('ActExt.administrador.certificacion', compact('certificados'));
            
    }

   public function showValidationForm($id_usuario) // Muestra el modal/formulario de validación (segunda interfaz)
    {
        $certificado = Certificacion::findOrFail($id_usuario);
        return view('ActExt.administrador.validar_certificado', compact('certificado'));
    }

   public function validarCertificado(Request $request) // Procesa la validación del certificado
    {
        $certificado = Certificacion::findOrFail($request->id_usuario);
        $certificado->validado = true;
        $certificado->save();

        return redirect()->route('admin.certificacion.ingles') ->with('success', 'El certificado ha sido validado correctamente.');
    }
}
