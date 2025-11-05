@extends('ActExt.layouts.profesor')

@section('title', 'Registro de Asistencias')

@section('content')
    @if (session('danger'))
        <div class="alert alert-danger">
            {{ session('danger') }}
        </div>
    @endif
    <div class="container">
        <h1 class="text-center mb-4"><b>Registro de Asistencias</b></h1>
        <input type="hidden" id="id_act" name="" value="{{ $id_actividad }}">
        @if ($asistenciasRegistradas)
            <div class="alert alert-info">Las asistencias ya han sido registradas para esta actividad.</div>
            <table class="table table-bordered table-hover table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Matrícula</th>
                        <th>Asistencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservaciones as $reserva)
                        <tr>
                            <td>{{ $reserva->usuario->nombre }}</td>
                            <td>{{ $reserva->usuario->matricula }}</td>
                            <td>
                                <span>{{ $reserva->asistencia ? ($reserva->asistencia->asistencia ? 'Asistió' : 'No Asistió') : 'No registrado' }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <!-- Si aún no se han registrado las asistencias, mostramos el formulario -->
            @if ($reservaciones->isEmpty())
                <div class="alert alert-warning text-center">No hay estudiantes registrados para esta actividad.</div>
            @else
                <form action="{{ route('actividades.guardarAsistencias', $id_actividad) }}" method="POST">

                    @csrf
                    <input type="hidden" name="fecha" value="{{ $fecha }}">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Matrícula</th>
                                    <th>Asistencia</th>
                                </tr>
                            </thead>
                            <tbody id="tabAsis">
                                
                            </tbody>
                        </table>
                    </div>

                    <!-- Botón para guardar las asistencias -->
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Guardar Asistencias</button>
                    </div>
                </form>
            @endif
        @endif
        <script>
            const csrfToken = "{{ csrf_token() }}";
            var idGet = document.getElementById('id_act').value;
        </script>
        @push('js')
            <script src="{{ asset('js/Administrador/asistencia.js') }}"></script>
        @endpush
    </div>
@endsection
