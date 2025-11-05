<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Reserva;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Mostrar la vista para registrar las asistencias de una actividad.
     *
     * @param  int  $id_actividad
     * @return \Illuminate\View\View
     */

    public function ajax($id_actividad)
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

        // Devolver la vista con las reservaciones y la variable de estado
        return response()->json([
            'reservaciones' => $reservaciones,
            'id_actividad' => $id_actividad,
            'asistenciasRegistradas' => $asistenciasRegistradas
        ]);
    }

    public function mostrarAsistencias($id_actividad)
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
        return view('ActExt.administrador.asistencias', compact('reservaciones', 'id_actividad', 'asistenciasRegistradas', 'fecha'));
    }

    /**
     * Guardar las asistencias de los estudiantes para una actividad.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_actividad
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guardarAsistencias(Request $request, $id_actividad)
    {
        $fechaFormateada = Carbon::parse($request->fecha)->format('Y-m-d');

        if ($fechaFormateada == date('Y-m-d')) {//verifica que sea la fecha de la actividad
            // Validar que los datos de asistencia están presentes en el request
            $request->validate([
                'asistencias' => 'required|array', // Asegurarse de que se reciban los datos de asistencia
                'asistencias.*' => 'in:asistio,no_asistio', // Validar las opciones de asistencia
            ]);

            // Obtener todas las reservas de la actividad
            $reservas = Reserva::whereHas('cita', function ($query) use ($id_actividad) {
                $query->where('id_actividad', $id_actividad);
            })->get();

            // Guardar o actualizar las asistencias
            foreach ($reservas as $reserva) {
                if (isset($request->asistencias[$reserva->id])) {
                    $asistencia = $request->asistencias[$reserva->id] === 'asistio' ? 1 : 0;

                    // Crear o actualizar la asistencia
                    Asistencia::updateOrCreate(
                        [
                            'id_usuario' => $reserva->id_usuario,
                            'id_cita' => $reserva->id_cita
                        ],
                        [
                            'asistencia' => $asistencia
                        ]
                    );
                }
            }

            // Redirigir con un mensaje de éxito
            return redirect()->route('actividades.asistencias', $id_actividad)
                ->with('success', 'Asistencias registradas correctamente.');
        }else{
            return redirect()->route('actividades.asistencias', $id_actividad)
            ->with('danger', 'No puedes registrar la asistencia antes de la fecha de la actividad.');
        }
    }
}
