<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    // Método para mostrar el formulario de crear nivel (si es necesario)
    public function create()
    {
        return view('nivel.create'); // Asegúrate de tener una vista en resources/views/nivel/create.blade.php
    }

    // Método para almacenar el nivel en la base de datos
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'nivel' => 'required|string|max:50|unique:niveles,nivel',
        ]);

        // Crear el nivel
        Nivel::create($request->all());

        return response()->json(['message' => 'Nivel creado exitosamente'], 201);
    }

    // Método para mostrar la lista de niveles
    public function index()
    {
        $niveles = Nivel::all(); // Obtiene todos los niveles
        return view('nivel.index', compact('niveles')); // Asegúrate de tener una vista en resources/views/nivel/index.blade.php
    }

    // Otros métodos como edit, update, destroy pueden ser añadidos aquí según sea necesario
}