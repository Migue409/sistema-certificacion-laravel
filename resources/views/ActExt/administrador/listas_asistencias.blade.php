@extends('ActExt.layouts.profesor')

@section('title', 'Registro de Asistencias')

@section('content')
    @if (session('danger'))
        <div class="alert alert-danger">
            {{ session('danger') }}
        </div>
    @endif
    <div class="container">
        <h1 class="text-center mb-4"><b>Listas de Asistencias</b></h1>
        <input type="hidden" id="id_act" name="" value="{{ $id_actividad }}">
        <a href="{{route('exportPDF', ['id' => $id_actividad])}}" class="btn btn-lg btn-danger mb-3">
            <i class="fa-solid fa-file-pdf"></i> Exportar a PDF
        </a>

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

        <script>
            const csrfToken = "{{ csrf_token() }}";
            var idGet = document.getElementById('id_act').value;
        </script>
        @push('js')
            <script src="{{ asset('js/Administrador/asistencia.js') }}"></script>
        @endpush
    </div>
@endsection
