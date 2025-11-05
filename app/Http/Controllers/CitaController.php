<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with('actividad')->get();
        return response()->json($citas); // Devuelve todas las citas
    }

    public function show($id)
    {
        $cita = Cita::with('actividad')->findOrFail($id);
        return response()->json($cita); // Devuelve una cita específica
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_actividad' => 'required|exists:actividades,id_actividad',
        ]);

        $cita = Cita::create($request->all());
        return response()->json($cita, 201); // Crea una nueva cita
    }

    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->update($request->all());
        return response()->json($cita); // Actualiza una cita
    }

    public function destroy($id)
    {
        Cita::destroy($id);
        return response()->json(null, 204); // Elimina una cita
    }
}