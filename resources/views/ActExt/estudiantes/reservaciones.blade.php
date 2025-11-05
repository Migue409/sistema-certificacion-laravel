@extends('ActExt.layouts.estudiante')

@section('content')
<div class="container mt-5">
    <h2>Mis Reservaciones</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if($reservaciones->isEmpty())
    <p>No tienes ninguna reservación.</p>
    @else
    <table class="table table-dark table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Actividad</th>
                <th>Salón</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Asistencia</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservaciones as $reserva)
            <tr>
                <td>{{ optional($reserva->cita)->actividad->actividad ?? 'Actividad no disponible' }}</td>
                <td>{{ optional($reserva->cita)->actividad->salon ?? 'Salón pendiente' }}</td>
                <td>{{ \Carbon\Carbon::parse($reserva->cita->actividad->fecha)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($reserva->cita->actividad->fecha)->format('H:i') }}</td>
                <td>{{ $reserva->estatus ?? 'No disponible' }}</td>
                <td>{{$reserva->asistencia}}</td>
                <td>
                    @if($reserva->asistencia == 'Asistió')
                        <span class="text-success"><b>Actividad Completada</b></span>
                    @elseif(\Carbon\Carbon::parse($reserva->cita->actividad->fecha) >= now() && $reserva->estatus != 'cancelada')
                    <form action="{{ route('estudiantes.cancelarReserva', ['id_reserva' => $reserva->id]) }}" method="POST" onsubmit="return confirmCancel()">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger">Cancelar</button>
                    </form>
                    @elseif($reserva->estatus == 'cancelada')
                    <span class="text-danger"><b>Actividad cancelada</b></span>
                    @else
                    <span class="text-muted">No disponible</span>
                    @endif
                </td>
            </tr>
            @empty
            <p>No tienes ninguna reservación.</p>
            @endforelse
        </tbody>
    </table>
    @endif
</div>
<script>
    function confirmCancel() {
        return confirm("¿Estás seguro de que deseas cancelar esta reserva?");
    }
</script>

@endsection
