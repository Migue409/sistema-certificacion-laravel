<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Usuario; // Importa el modelo de Usuario
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesorController extends Controller
{
    // Mostrar todos los profesores 
    public function index() 
    {
        $profesores = Usuario::where('id_rol', 3)->get(); // Obtener solo los usuarios con rol de profesor
        return view('ActExt.profesores.index', compact('profesores')); // Retornar la vista con los profesores
    }

    

    public function actividadProfesor(Request $request)
    {
        // Obtener el valor de la fecha si se envió, o dejarlo como null si está vacío
        $fecha = $request->input('fecha');

        // Si no se ingresó ninguna fecha, mostrar todas las actividades
        $actividades = Actividad::where('id_usuario', Auth::id())
            ->orderBy('fecha', 'desc')
            ->get();

        foreach ($actividades as $value) {
            $nombreDoc[] = Usuario::where('id_usuario', $value->id_usuario)->value('nombre');
        }

        return view('ActExt.profesores.actividadesProfesor', compact('actividades'));
    }

    // Mostrar formulario para crear un nuevo profesor
    public function create()
    {
        return view('ActExt.profesores.create'); // Retornar la vista del formulario
    }

    // Almacenar un nuevo profesor
    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required|unique:usuarios,matricula',
            'nombre' => 'required|string|max:255',
            'curp' => 'required|string|max:18',
        ]);

        // Crear el nuevo profesor
        $profesor = new Usuario();
        $profesor->matricula = $request->matricula;
        $profesor->nombre = $request->nombre;
        $profesor->curp = $request->curp;
        $profesor->correo = $request->correo;
        $profesor->id_rol = 3; // Rol de profesor
        $profesor->save();

        return redirect()->route('profesores.index')->with('success', 'Profesor agregado correctamente.');
    }

    // Mostrar un profesor específico
    public function show(Usuario $profesor)
    {
        return view('ActExt.profesores.show', compact('profesor')); // Retornar la vista con el profesor
    }

    // Mostrar formulario para editar un profesor
    public function edit($id)
    {
        $profesor = Usuario::findOrFail($id);
        return view('ActExt.profesores.edit', compact('profesor'));
    }

    public function update(Request $request, $id_usuario)
    {
        $profesor = Usuario::findOrFail($id_usuario); // Encuentra el profesor por id_usuario

        $request->validate([
            'nombre' => 'required|string|max:255',
            'curp' => 'required|string|max:18|unique:usuarios,curp,' . $profesor->id_usuario . ',id_usuario',
        ]);

        // Actualizar solo los campos 'nombre' y 'curp'
        $profesor->nombre = $request->input('nombre');
        $profesor->curp = $request->input('curp');
        $profesor->save(); // Guarda los cambios en la base de datos

        return redirect()->route('profesores.index')->with('success', 'Profesor actualizado exitosamente.');
    }

    // Eliminar un profesor específico
    public function destroy($id)
    {
        $profesor = Usuario::findOrFail($id); // Buscar el profesor por ID
        $profesor->delete(); // Eliminar el profesor
    
        return redirect()->route('profesores.index')->with('success', 'Profesor eliminado exitosamente.');
    }
}
