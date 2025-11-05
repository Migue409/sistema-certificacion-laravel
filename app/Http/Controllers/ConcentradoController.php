<?php

namespace App\Http\Controllers;

use App\Models\DatosAcademicos;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConcentradoController extends Controller
{
    public function registro(Request $req)
    {
        // Convertir el valor de recurse a 1 o 0
        $recurse = trim(strtoupper($req->recurse));  // Limpiar y convertir a mayúsculas
        $recurseValue = ($recurse === 'SÍ' || $recurse === 'SI') ? 1 : 0;

        // Buscar o crear el usuario
        $usuario = Usuario::updateOrCreate(
            ['matricula' => $req->matricula],
            ['nombre' => $req->nombre, 'curp' => $req->curp, 'id_rol' => 2, 'correo' => $req->correo]
        );

        // Actualizar o crear los datos académicos usando el id del usuario recién creado
        DatosAcademicos::updateOrCreate(
            ['id_usuario' => $usuario->id_usuario],
            [
                'nivel' => $req->nivel,
                'recurse' => $recurseValue,
                'division' => $req->divi,
                'grupo_division' => $req->grupoDiv,
                'grupo_ingles' => $req->grupoIng
            ]
        );
        return redirect()->route('login.form')->with('success', "Registro exitoso, inicia sesión.");
    }
    // Método para mostrar la vista de búsqueda de estudiantes
    public function index()
    {
        return view('ActExt.administrador.info_estudiantes'); // Asegúrate de que este nombre coincida con la vista que tienes
    }

    public function download()
    {
        $filePath = storage_path('app/public/FORMATO_ESTUDIANTES_EXTRAINGLES.csv'); // Ruta completa al archivo

        // Verifica que el archivo exista
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->back()->withErrors(['error' => 'El archivo no se encuentra disponible para descargar.']);
    }

    public function upload(Request $request)
    {
        // Validación del archivo
        $request->validate(['file' => 'required|mimes:csv,txt|max:2048']);

        // Procesar el archivo CSV
        $file = $request->file('file');
        $data = array_map('str_getcsv', file($file));

        // Validar el formato del CSV
        $headers = ['MATRICULA', 'NOMBRE', 'CURP', 'NIVEL', 'RECURSE', 'DIVISION', 'GRUPO_DIVISION', 'GRUPO_INGLES'];
        if (array_map('strtoupper', $data[0]) !== array_map('strtoupper', $headers)) {
            return redirect()->back()->withErrors(['error' => 'El formato del archivo CSV no es válido.']);
        }

        $errors = []; // Array para capturar errores
        $procesados = 0; // Contador de registros procesados

        // Iterar sobre cada fila del CSV y procesar los datos
        foreach (array_slice($data, 1) as $row) {
            if (count($row) !== count($headers)) {
                $errors[] = 'Fila ' . (count($errors) + 2) . ': Longitud incorrecta.';
                continue;
            }

            // Descomponer la fila
            [$matricula, $nombre, $curp, $nivel, $recurse, $division, $grupo_division, $grupo_ingles] = $row;

            // Convertir el valor de recurse a 1 o 0
            $recurse = trim(strtoupper($recurse));  // Limpiar y convertir a mayúsculas
            $recurseValue = ($recurse === 'SÍ' || $recurse === 'SI') ? 1 : 0;

            // Buscar o crear el usuario
            $usuario = Usuario::updateOrCreate(
                ['matricula' => $matricula],
                ['nombre' => $nombre, 'curp' => $curp, 'id_rol' => 2]
            );

            // Actualizar o crear los datos académicos usando el id del usuario recién creado
            DatosAcademicos::updateOrCreate(
                ['id_usuario' => $usuario->id_usuario],
                [
                    'nivel' => $nivel,
                    'recurse' => $recurseValue,
                    'division' => $division,
                    'grupo_division' => $grupo_division,
                    'grupo_ingles' => $grupo_ingles
                ]
            );

            $procesados++; // Aumentar el contador de registros procesados
        }

        // Mensaje de éxito o error
        if (empty($errors)) {
            return redirect()->back()->with('success', "Se han procesado $procesados registros correctamente.");
        } else {
            return redirect()->back()->withErrors(['error' => 'Algunos datos no se procesaron: ' . implode(', ', $errors)]);
        }
    }

    public function buscarEstudiantes(Request $request)
    {
        $matriculas = $request->input('matriculas');

        // Asegúrate de que se reciban matriculas
        if (!$matriculas || !is_array($matriculas)) {
            return response()->json([]);
        }

        // Realizar la búsqueda
        $estudiantes = Usuario::whereIn('matricula', $matriculas)->get(['matricula', 'nombre']);

        return response()->json($estudiantes);
    }

    public function buscarEstudianteInfo(Request $request)
    {
        $matricula = $request->input('matricula');

        // Cargar al estudiante que tenga el rol de estudiante (id_rol = 2) junto con los datos académicos
        $estudiante = Usuario::where('matricula', $matricula)
            ->where('id_rol', 2)
            ->with('datosAcademicos')
            ->first();

        if ($estudiante) {
            // Usando optional() para evitar error si datosAcademicos es null
            $datosAcademicos = optional($estudiante->datosAcademicos);

            return response()->json([
                'matricula' => $estudiante->matricula,
                'nombre' => $estudiante->nombre,
                'curp' => $estudiante->curp,
                'nivel' => $datosAcademicos->nivel ?? 'No disponible',
                'recurse' => $datosAcademicos->recurse ?? 0,
                'division' => $datosAcademicos->division ?? 'No disponible',
                'grupo_division' => $datosAcademicos->grupo_division ?? 'No disponible',
                'grupo_ingles' => $datosAcademicos->grupo_ingles ?? 'No disponible',
            ]);
        }

        return response()->json([], 404); // Estudiante no encontrado
    }
}
