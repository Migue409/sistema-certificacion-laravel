<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Reserva;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MailController;
use App\Models\Usuario;
use Illuminate\Pagination\Paginator;

class ReservaController extends Controller
{


    public function index()
    {
        // Traer todas las reservas con las relaciones necesarias
        $reservas = Reserva::with(['usuario', 'cita', 'cita.actividad'])->paginate(10);
        dd($reservas);
        //return view('administrador.reservas', compact('reservas'));
    }

    public function ajax()
    {
        // Traer todas las reservas con las relaciones necesarias
        $reservas = Reserva::with(['usuario', 'cita', 'cita.actividad', 'asistencia'])->get();

        return response()->json($reservas);
    }

    public function show($id)
    {
        $reserva = Reserva::with(['usuario', 'cita'])->findOrFail($id);
        return response()->json($reserva); // Devuelve una reserva específica
    }

    public function confirmarReserva($idActividad)
    {
        // Buscar la actividad
        $actividad = Actividad::findOrFail($idActividad);

        // Verificar si hay cupos disponibles
        if ($actividad->cupo_disponible <= 0) {
            return redirect()->route('estudiantes.reservar')->with('error', 'No hay cupos disponibles para esta actividad.');
        }

        // Verificar si el estudiante ya tiene una reserva activa para esta actividad
        $reservaExistente = Reserva::where('id_usuario', Auth::id())
            ->whereHas('cita', function ($query) use ($actividad) {
                $query->where('id_actividad', $actividad->id_actividad);
            })
            ->where('estatus', 'reservado') // Solo ver las reservas activas
            ->exists();

        if ($reservaExistente) {
            return redirect()->route('estudiantes.reservar')->with('error', 'Ya tienes una reservación para esta actividad.');
        }

        // Iniciar una transacción
        DB::beginTransaction();

        try {
            // Restar un cupo disponible en la actividad
            $actividad->cupo_disponible -= 1;
            $actividad->save();

            // Crear una nueva cita para esta actividad
            $cita = Cita::create([
                'id_actividad' => $actividad->id_actividad,  // ID de la actividad
            ]);

            // Crear la reserva en la tabla reservas
            Reserva::create([
                'id_usuario' => Auth::id(),  // ID del usuario autenticado
                'id_cita' => $cita->id,      // ID de la cita recién creada
                'estatus' => 'reservado',    // Estado de la reserva
            ]);

            // Confirmar la transacción
            DB::commit();


            $alumno = Usuario::where('id_usuario', Auth::id())->get();
            $profesor = Usuario::where('id_usuario', $actividad->id_usuario)->get();

            $nombre = $alumno->first()->nombre;

            $actividadd = $actividad->actividad;
            $destinatario = $alumno->first()->correo;
            $aula = $actividad->salon;
            $docente = $profesor->first()->nombre;
            $fecha      = now()->format('d-m-Y H:i');
            $tipoMsn = 1;
            $logoUrl = asset('images/logoCoordinacion.png');

            $mailController = new MailController();
            $mailController->enviarCorreo($destinatario, $aula, $docente, $fecha, $tipoMsn, $actividadd, $nombre,$logoUrl);

            return redirect()->route('estudiantes.reservar')->with('success', 'Reserva realizada con éxito.');
        } catch (\Exception $e) {

            // Revertir la transacción si hay un error
            DB::rollBack();
            Log::info($e);
            return redirect()->route('estudiantes.reservar')->with('error', 'Ocurrió un problema al realizar la reserva. Inténtalo de nuevo.');
        }
    }

    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update($request->all());
        return response()->json($reserva); // Actualiza una reserva
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Encontrar la reserva
            $reserva = Reserva::findOrFail($id);

            // Aumentar el cupo disponible en la actividad asociada a la cita
            $actividad = $reserva->cita->actividad;
            $actividad->cupo_disponible += 1;
            $actividad->save();

            // Eliminar la reserva
            $reserva->delete();

            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al eliminar la reserva.'], 500);
        }
    }

    public function misReservaciones()
    {
        $reservaciones = Reserva::where('id_usuario', Auth::id())
            ->get();

        // Cargar manualmente las relaciones
        $reservaciones->load(['cita', 'cita.actividad', 'cita.asistencias']);

        // Agregar la asistencia a cada reserva
        foreach ($reservaciones as $reserva) {
            // Buscar la asistencia en la tabla asistencias usando id_usuario y id_cita
            $asistencia = $reserva->cita->asistencias->where('id_usuario', Auth::id())->first();

            // Establecer la asistencia como 'Pendiente' si no existe, 'Asistió' si 1, o 'No Asistió' si 0
            $reserva->asistencia = $asistencia
                ? ($asistencia->asistencia == 1 ? 'Asistió' : 'No Asistió')
                : 'Pendiente';
        }

        return view('ActExt.estudiantes.reservaciones', compact('reservaciones'));
    }



    // Método para cancelar una reservación
    public function cancelarReserva($id_reserva)
    {
        // Obtener la reserva por su ID
        $reserva = Reserva::findOrFail($id_reserva);

        // Encuentra la actividad relacionada con la cita
        $actividad = $reserva->cita->actividad;

        // Cambiar el estatus de la reserva a "cancelada"
        $reserva->estatus = 'cancelada'; // O el valor que corresponda
        $reserva->save();

        // Incrementa el cupo disponible de la actividad
        $actividad->cupo_disponible += 1;
        $actividad->save();

        $actividadds = DB::table('reservas')
            ->join('citas', 'reservas.id_cita', '=', 'citas.id')
            ->join('actividades', 'citas.id_actividad', '=', 'actividades.id_actividad')
            ->where('reservas.id', $id_reserva)
            ->select('actividades.*')
            ->get();

        $alumno = Usuario::where('id_usuario', Auth::id())->get();
        $profesor = Usuario::where('id_usuario', $actividadds->first()->id_usuario)->get();

        $nombre = $alumno->first()->nombre;

        $actividadd = $actividad->actividad;
        $destinatario = $alumno->first()->correo;
        $aula = $actividad->salon;
        $docente = $profesor->first()->nombre;
        $fecha      = now()->format('d-m-Y H:i');
        $tipoMsn = 1;
        $logoUrl = asset('images/logoCoordinacion.png');

        $mailController = new MailController();
        $mailController->enviarCorreo($destinatario, $aula, $docente, $fecha, $tipoMsn, $actividadd, $nombre,$logoUrl);


        // Redirigir con un mensaje de éxito
        return redirect()->route('estudiantes.reservaciones')->with('success', 'Reserva cancelada con éxito.');
    }

    public function cancelarReservacionesActividad($id_actividad)
    {
        // Buscar la actividad por su ID
        $actividad = Actividad::findOrFail($id_actividad);

        // Obtener todas las reservaciones de la actividad
        $reservas = Reserva::whereHas('cita', function ($query) use ($id_actividad) {
            $query->where('id_actividad', $id_actividad);
        })->get();

        // Cambiar el estatus de todas las reservaciones a "cancelada"
        foreach ($reservas as $reserva) {
            $reserva->estatus = 'cancelada';
            $reserva->save();
        }

        // Actualizar el cupo y cupo disponible de la actividad a cero
        $actividad->cupo = 0;
        $actividad->cupo_disponible = 0;
        $actividad->save();

        //Mensaje al profesor
        $actividad = Actividad::where('id_actividad', $id_actividad)->get();
        $docente = Usuario::where('id_usuario', $actividad->first()->id_usuario)->get();

   

        $nombre = "";
        $actividadProf = $actividad->first()->actividad;
        $destinatario = $docente->first()->correo;
        $aula = $actividad->first()->salon;
        $nomDoc = $docente->first()->nombre;
        $fecha = $actividad->first()->fecha;
        $tipoMsn = 6;
        $logoUrl = asset('images/logoCoordinacion.png');

        $mailController = new MailController();
        $mailController->enviarCorreo($destinatario, $aula, $nomDoc, $fecha, $tipoMsn, $actividadProf, $nombre,$logoUrl);
        //

        //for para el envio a todos los alumnos que esten inscritos a esta actividad
        $alumnosInscritos = Usuario::join('reservas', 'usuarios.id_usuario', '=', 'reservas.id_usuario')
            ->join('citas', 'reservas.id_cita', '=', 'citas.id')
            ->where('citas.id_actividad', $id_actividad)
            ->select('usuarios.*')
            ->get();

        foreach ($alumnosInscritos as $alumno) {
            $nombreAlum = $alumno->nombre;
            $actividadAlum = $actividad->first()->actividad;
            $destinatario = $alumno->correo;
            $aula = $actividad->first()->salon;
            $nomDoc = $docente->first()->nombre;
            $fecha = $actividad->first()->fecha;
            $tipoMsnAl = 2;
            $logoUrl = asset('images/logoCoordinacion.png');

            $mailController = new MailController();
            $mailController->enviarCorreo($destinatario, $aula, $nomDoc, $fecha, $tipoMsnAl, $actividadAlum, $nombreAlum, $logoUrl);
        }
        //

        // Redirigir con un mensaje de éxito
        return redirect()->route('actividades.index')->with('success', 'Reservaciones de la actividad canceladas y cupo actualizado a cero.');
    }
}
