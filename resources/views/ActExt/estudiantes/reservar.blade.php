@extends('ActExt.layouts.estudiante')

@section('content')
    <div class="container mt-5">
        <h2>
            <center>Reservar Actividad</center>
        </h2>

        <!-- Formulario para elegir tipo de actividad -->
        <form action="{{ route('estudiantes.reservar') }}" method="GET">
            <div class="form-group">
                <select id="actividad" name="actividad" class="form-control">
                    <option value="">Seleccione una actividad</option>
                    <option value="speaking" {{ request('actividad') == 'speaking' ? 'selected' : '' }}>Speaking</option>
                    <option value="asesoria" {{ request('actividad') == 'asesoria' ? 'selected' : '' }}>Asesoría</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Buscar Actividades</button>
            <hr>
        </form>

        <!-- Mostrar mensaje si no se ha seleccionado ninguna actividad -->
        @if (request('actividad') == null)
            <p class="alert alert-warning">Por favor, seleccione una actividad para ver disponibilidad.</p>
        @else
            <!-- Mostrar actividades disponibles -->
            @if ($actividades->isEmpty())
                <p class="alert alert-danger"><b>No hay actividades disponibles.</b></p>
            @else
                <h4 class="mt-4">Actividades Disponibles</h4>
                <table class="table mt-3" id="actividades-table">
                    <thead>
                        <tr>
                            <th>Actividad</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Cupos Disponibles</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actividades as $actividad)
                            <tr>
                                <td>{{ $actividad->actividad }}</td>
                                <td>{{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($actividad->fecha)->format('H:i') }}</td>
                                <td>{{ $actividad->cupo_disponible }}</td>
                                <td>
                                    <a href="{{ route('estudiantes.reservar.confirmar', ['actividad' => $actividad->id_actividad]) }}"
                                        class="btn btn-success">Reservar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @push('js')
                    
                @endpush
            @endif
        @endif
        @if (session('success'))
            <meta name="toast-success" content="{{ session('success') }}">
        @endif
        @if (session('error'))
            <meta name="toast-error" content="{{ session('error') }}">
        @endif
    </div>
@endsection
