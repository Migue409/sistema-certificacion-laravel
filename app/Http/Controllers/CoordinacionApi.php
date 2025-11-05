<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoordinacionApi extends Controller
{
    public function ajaxProfesor(Request $request)
    {
        // Si no se ingresó ninguna fecha, mostrar todas las actividades
        $actividades = Actividad::where('id_usuario', Auth::id())
            ->orderBy('fecha', 'desc')
            ->get();

        foreach ($actividades as $value) {
            $nombreDoc[] = Usuario::where('id_usuario', $value->id_usuario)->value('nombre');
        }

        return response()->json($actividades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
