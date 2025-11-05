<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Nivel;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
use App\Models\Asistencia;
use App\Models\Reserva;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;

class ActividadController extends Controller
{

    public function validacionDocente($fecha, $hora)
    {
        $fechaHora = Carbon::parse("{$fecha}{$hora}");
        $usuarios = DB::table('usuarios')
            ->leftJoin('actividades', function ($join) use ($fechaHora) {
                $join->on('actividades.id_usuario', '=', 'usuarios.id_usuario')
                    ->where('actividades.fecha', '=', $fechaHora);
            })
            ->where('usuarios.id_rol', 3)
            ->whereNull('actividades.id_usuario')  // Filtra los usuarios sin actividad en esa fecha
            ->select('usuarios.nombre', 'usuarios.id_usuario')
            ->get();

        return response()->json($usuarios);
    }

    public function index(Request $request)
    {
        // Obtener el valor de la fecha si se envió, o dejarlo como null si está vacío
        $fecha = $request->input('fecha');

        if (!empty($fecha)) {
            // Filtrar actividades por la fecha específica si se ingresó una
            $actividades = Actividad::whereDate('fecha', $fecha)->get();
        } else {
            // Si no se ingresó ninguna fecha, mostrar todas las actividades
            $actividades = Actividad::all();
        }
        return view('ActExt.administrador.admin', compact('actividades'));
    }

    public function listaAsis($id_actividad)
    {
        // Obtener las reservaciones con estatus 'reservado' y cargar los usuarios relacionados
        $reservaciones = Reserva::whereHas('cita', function ($query) use ($id_actividad) {
            $query->where('id_actividad', $id_actividad); // Filtrar por actividad
        })
            ->where('estatus', 'reservado') // Filtrar por estatus 'reservado'
            ->with(['usuario', 'cita.actividad', 'asistencia']) // Cargar las relaciones necesarias
            ->get();

        // Verificar si ya existen registros de asistencias para esta actividad
        $asistenciasRegistradas = Asistencia::whereHas('cita', function ($query) use ($id_actividad) {
            $query->where('id_actividad', $id_actividad); // Filtrar por actividad
        })->exists();

        $fecha = Actividad::where('id_actividad', $id_actividad)->value('fecha');

        // Devolver la vista con las reservaciones y la variable de estado
        return view('ActExt.administrador.listas_asistencias', compact('reservaciones', 'id_actividad', 'asistenciasRegistradas', 'fecha'));
    }

    public function ajax(Request $request)
    {

        // Obtener el valor de la fecha si se envió, o dejarlo como null si está vacío
        $fecha = $request->input('fecha');

        if (!empty($fecha)) {
            // Filtrar actividades por la fecha específica si se ingresó una
            $actividades = Actividad::whereDate('fecha', $fecha)->get();
        } else {
            // Si no se ingresó ninguna fecha, mostrar todas las actividades
            $actividades = Actividad::join('usuarios','actividades.id_usuario','=','usuarios.id_usuario')->select('usuarios.*','actividades.*')->get();

        }
        return response()->json( $actividades);
    }

    // Método para mostrar el formulario de crear actividad (si es necesario)
    public function create()
    {
        $niveles = Nivel::all(); // Asegúrate de importar el modelo de Nivel
        $docente = Usuario::where('id_rol', 3)->get();
        return view('ActExt.administrador.create_actividad', compact('niveles', 'docente'));
    }

    // Método para almacenar la actividad en la base de datos
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'actividad' => 'required|string|max:255',
            'id_nivel' => 'required|exists:niveles,id_nivel',
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'fecha' => 'required|date', // Validar como fecha
            'hora' => 'required|date_format:H:i', // Asegurarse de que la hora esté en formato 24 horas
            'cupo' => 'required|integer|min:1|max:60', // Establecer un máximo de 60
            'salon' => 'nullable|string|max:100',
        ]);

        // Combinar fecha y hora
        try {
            $fechaHora = Carbon::parse("{$request->fecha} {$request->hora}");
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la fecha y hora.'], 400);
        }

        // Verificar conflictos en el horario
        $conflicto = Actividad::where('fecha', $fechaHora)
            ->where('salon', $request->salon)
            ->exists();

        if ($conflicto) {
            // Redirigir al formulario con un mensaje de error y mantener los datos ingresados
            return redirect()->back()
                ->withErrors(['error' => 'Conflicto de horario en el mismo salón. Intente con otro horario o salón.'])
                ->withInput();
        }

        // Crear la actividad y establecer cupo disponible igual a cupo
        Actividad::create([
            'actividad' => $request->actividad,
            'id_nivel' => $request->id_nivel,
            'fecha' => $fechaHora, // Almacenar la fecha y hora combinadas
            'cupo' => $request->cupo,
            'cupo_disponible' => $request->cupo, // Establecer el cupo disponible
            'id_usuario' => $request->id_usuario,
            'salon' => $request->salon,
        ]);

        $docente = Usuario::where('id_usuario', $request->id_usuario)->get();

        $nombre = "";
        $actividad = $request->actividad;
        $destinatario = $docente->first()->correo;
        $aula = $request->salon;
        $nomDoc = $docente->first()->nombre;
        $fecha = $fechaHora;
        $tipoMsn = 5;
        $logoUrl = asset('images/logoCoordinacion.png');
        
        $mailController = new MailController();
        $mailController->enviarCorreo($destinatario, $aula, $nomDoc, $fecha, $tipoMsn, $actividad, $nombre, $logoUrl);
        return redirect()->route('admin.index')->with('success', 'Actividad creada exitosamente');
    }

    public function enviarmensaje(){
        $nombre = "";
        $actividad = 'prueba';
        $destinatario = 'alan.adaair@gmail.com';
        $aula = 'zb03';
        $nomDoc = 'Cesar';
        $fecha = '21/03/2025 17:00';
        $tipoMsn = 5;
        $logoUrl = asset('images/logoCoordinacion.png');
        $mailController = new MailController();
        $mailController->enviarCorreo($destinatario, $aula, $nomDoc, $fecha, $tipoMsn, $actividad, $nombre, $logoUrl);
        
    }

    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id); // Obtener la actividad por ID
        $niveles = Nivel::all(); // Obtener todos los niveles para el select

        // Si fecha no es un objeto Carbon, conviértela
        if (is_string($actividad->fecha)) {
            $actividad->fecha = Carbon::parse($actividad->fecha);
        }

        return view('ActExt.administrador.edit_actividad', compact('actividad', 'niveles'));
    }

    public function update(Request $request, $id_actividad)
    {
        try {
            // Validación de los datos
            $request->validate([
                'fecha' => 'required|date',
                'hora_display' => 'required|string', // Asegúrate de validar la hora
                'cupo' => 'required|integer|min:1|max:60',
                'salon' => 'nullable|string|max:100',
                'id_usuario' => 'required|exists:usuarios,id_usuario',
            ]);

            $actividad = Actividad::findOrFail($id_actividad);

            // Combina la fecha y la hora
            $fechaHora = $request->input('fecha') . ' ' . $request->input('hora_display');

            // Verificar conflictos en el horario
            $conflicto = Actividad::where('fecha', $fechaHora)
                ->where('salon', $request->salon)
                ->where('id_actividad', '!=', $id_actividad) // Ignorar la actividad actual
                ->exists();

            if ($conflicto) {

                return redirect()->back()->withErrors(['error' => 'Conflicto de horario en el mismo salón. Intente con otro horario o salón.']);
            }

            // Actualiza los campos de la actividad
            $actividad->fecha = \Carbon\Carbon::parse($fechaHora); // Asegúrate de usar Carbon para manejar las fechas
            $actividad->salon = $request->input('salon');
            $actividad->cupo = $request->input('cupo');
            $actividad->cupo_disponible = $request->input('cupo');
            $actividad->id_usuario = $request->input('id_usuario');

            // Guarda los cambios en la base de datos
            $actividad->save();

            //Mensaje al profesor
            $docente = Usuario::where('id_usuario', $request->id_usuario)->get();

            $nombre = "";
            $actividad = $request->actividad;
            $destinatario = $docente->first()->correo;
            $aula = $request->salon;
            $nomDoc = $docente->first()->nombre;
            $fecha = $fechaHora;
            $tipoMsn = 7;
            $logoUrl = asset('images/logoCoordinacion.png');

            $mailController = new MailController();
            $mailController->enviarCorreo($destinatario, $aula, $nomDoc, $fecha, $tipoMsn, $actividad, $nombre,$logoUrl);
            //

            //for para el envio a todos los alumnos que esten inscritos a esta actividad
            $alumnosInscritos = Usuario::join('reservas', 'usuarios.id_usuario', '=', 'reservas.id_usuario')
                ->join('citas', 'reservas.id_cita', '=', 'citas.id')
                ->where('citas.id_actividad', $id_actividad)
                ->select('usuarios.*')
                ->get();

            foreach ($alumnosInscritos as $alumno) {
                $nombreAlum = $alumno->nombre;
                $actividadAlum = $request->actividad;
                $destinatario = $alumno->correo;
                $aula = $request->salon;
                $nomDoc = $docente->first()->nombre;
                $fecha = $fechaHora;
                $tipoMsnAl = 4;
                $logoUrl = asset('images/logoCoordinacion.png');

                $mailController = new MailController();
                $mailController->enviarCorreo($destinatario, $aula, $nomDoc, $fecha, $tipoMsnAl, $actividadAlum, $nombreAlum,$logoUrl);
            }
            //

        } catch (\Throwable $th) {
            Log::info($th);
        }

        return redirect()->route('admin.index')->with('success', 'Actividad actualizada exitosamente');
    }
}
