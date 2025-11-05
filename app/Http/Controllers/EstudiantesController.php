<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Cita;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EstudiantesController extends Controller
{

    public function aviso()
    {
        $actividades = DB::table('actividades')
            ->select(
                'actividades.*',
                'usuarios.*',
                DB::raw('(SELECT u.nombre FROM usuarios u WHERE u.id_usuario = actividades.id_usuario) AS nombre_profesor_actividad')
            )
            ->join('citas', 'actividades.id_actividad', '=', 'citas.id_actividad')
            ->join('reservas', 'citas.id', '=', 'reservas.id_cita')
            ->join('usuarios', 'usuarios.id_usuario', '=', 'reservas.id_usuario')
            ->whereDate('actividades.fecha', '=', DB::raw('DATE_ADD(CURDATE(), INTERVAL 3 DAY)'))
            ->get();

        foreach ($actividades as $msn) {
            try {
                $nombre = $msn->nombre;
                $actividad = $msn->actividad;
                $destinatario = $msn->correo;
                $aula = $msn->salon;
                $nomDoc = $msn->nombre_profesor_actividad;
                $fecha = $msn->fecha;
                $tipoMsn = 3;
                $logoUrl = asset('images/logoCoordinacion.png');

                $mailController = new MailController();
                $mailController->enviarCorreo($destinatario, $aula, $nomDoc, $fecha, $tipoMsn, $actividad, $nombre, $logoUrl);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        return $actividades;
    }
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Evitar la caché en las respuestas
            $response = $next($request);
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
            return $response;
        });
    }

    public function index()
    {
        // Obtener el usuario autenticado
        $estudiante = Auth::user();

        // Verificar si el estudiante es una instancia de Usuario
        if ($estudiante instanceof Usuario) {
            // Cargar la relación 'datosAcademicos'
            $estudiante->load('datosAcademicos');
        } else {
            return redirect()->route('login')->with('error', 'Usuario no autenticado');
        }

        // Pasar los datos a la vista
        return view('ActExt.estudiantes.index', compact('estudiante'));
    }

    public function reservar(Request $request)
    {
        // Obtener el nivel del estudiante autenticado
        $nivelEstudiante = Auth::user()->datosAcademicos->nivel;

        // Obtener la fecha y hora actual
        $now = Carbon::now();

        // Obtener las actividades según la actividad seleccionada, el nivel del estudiante, y la fecha y hora
        $actividades = DB::table('actividades')
            ->join('niveles', 'actividades.id_nivel', '=', 'niveles.id_nivel')
            ->where('niveles.nivel', $nivelEstudiante)
            ->where('actividades.cupo_disponible', '>', 0)
            // Filtrar solo las actividades que tengan una fecha posterior a la actual
            ->where('actividades.fecha', '>=', $now)
            ->when($request->actividad, function ($query, $actividad) {
                return $query->where('actividades.actividad', $actividad);
            })
            ->select('actividades.*')
            ->get();

        // Retornar la vista con las actividades disponibles
        return view('ActExt.estudiantes.reservar', compact('actividades'));
    }


    // Método para consultar las reservaciones
    public function reservaciones()
    {
        // Obtener el ID del estudiante autenticado
        $idUsuario = Auth::user()->id_usuario;

        // Obtener las reservaciones del estudiante, considerando que la fecha está en actividades
        $reservaciones = DB::table('reservas')
            ->join('citas', 'reservas.id_cita', '=', 'citas.id')
            ->join('actividades', 'citas.id_actividad', '=', 'actividades.id_actividad')
            ->where('reservas.id_usuario', $idUsuario)
            ->select('reservas.*', 'actividades.actividad', 'actividades.fecha')
            ->get();

        // Retornar la vista con las reservaciones
        return view('ActExt.estudiantes.reservaciones', compact('reservaciones'));
    }

}
