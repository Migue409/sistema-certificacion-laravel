<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosAcademicos;
use Illuminate\Support\Facades\Validator;

class DatosAcademicosController extends Controller
{
    public function index()
    {
        // Obtén todos los datos académicos
        $datosAcademicos = DatosAcademicos::with('usuario')->get();
        return view('datos_academicos.index', compact('datosAcademicos'));
    }

    public function create()
    {
        // Mostrar el formulario para crear un nuevo registro
        return view('datos_academicos.create');
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:usuarios,id',
            'nivel' => 'required|string',
            'recurse' => 'required|string',
            'division' => 'required|string',
            'grupo_division' => 'required|string',
            'grupo_ingles' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear un nuevo registro de datos académicos
        DatosAcademicos::create($request->all());

        return redirect()->route('datos_academicos.index')->with('success', 'Datos académicos creados correctamente.');
    }

    public function edit($id)
    {
        // Mostrar el formulario para editar un registro
        $datosAcademicos = DatosAcademicos::findOrFail($id);
        return view('datos_academicos.edit', compact('datosAcademicos'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'nivel' => 'required|string',
            'recurse' => 'required|string',
            'division' => 'required|string',
            'grupo_division' => 'required|string',
            'grupo_ingles' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Actualizar el registro de datos académicos
        $datosAcademicos = DatosAcademicos::findOrFail($id);
        $datosAcademicos->update($request->all());

        return redirect()->route('datos_academicos.index')->with('success', 'Datos académicos actualizados correctamente.');
    }

    public function destroy($id)
    {
        // Eliminar un registro de datos académicos
        $datosAcademicos = DatosAcademicos::findOrFail($id);
        $datosAcademicos->delete();

        return redirect()->route('datos_academicos.index')->with('success', 'Datos académicos eliminados correctamente.');
    }
}