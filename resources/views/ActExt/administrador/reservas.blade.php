@extends('ActExt.layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Reservas de Actividades</h1>

        <!-- Botón para exportar las reservas a Excel -->
        <div class="mb-4 text-center">
            <a href="{{ route('exportar.reservas') }}" class="btn btn-success">
                Exportar a Excel
            </a>
        </div>

        <!-- Tabla de reservas -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Fecha</th>
                    <th>Actividad</th>
                    <th>Asistencia</th>
                </tr>
            </thead>
            <tbody id="tabResv">
                
            </tbody>
        </table>
        @push('js')
            <script src="{{ asset('js/Administrador/reserva.js') }}"></script>
        @endpush
    </div>
@endsection
