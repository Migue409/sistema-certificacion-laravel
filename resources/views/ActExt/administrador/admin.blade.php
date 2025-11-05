@extends('ActExt.layouts.app') <!-- Extiende el layout base -->

@section('title', 'Panel de Administración') <!-- Título de la página -->

@section('content')
    <div class="container">
        <h1>
            <center><b>Panel de Administración</b></center>
        </h1>

        

        <div class="activity-list mt-3">
            <div class="d-flex justify-content-between">
                <h2>Actividades</h2>
                <a href="{{ route('actividades.create') }}" class="btn btn-success" style="padding: 10px 10px;">Agregar
                    Actividad</a>
            </div>
            <hr>
            @if ($actividades->isEmpty())
                <div class="alert alert-warning" role="alert">
                    No hay actividades registradas para la fecha seleccionada.
                </div>
            @else
                <!-- Hacer la tabla responsive en dispositivos pequeños -->
                <div class="table-responsive">
                    <table id="tabActs" class="table table-dark table-hover table-bordered table-striped align-middle display mt-5" 
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Actividad</th>
                                <th scope="col">Docente</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Salón</th>
                                <th scope="col">Cupo</th>
                                <th scope="col">Cupo Disponible</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id=""> 

                        </tbody>
                    </table>
            @endif 
        </div>
    </div>
    <script>
        const csrfToken = "{{ csrf_token() }}";
        var cancelarReservasRoute = "{{ route('actividades.cancelarReservas', ':id') }}";
        var editarRoute = "{{ route('actividades.edit', ':id') }}";
        var asistenciasRoute = "{{ route('asistencias.admin', ':id') }}";
    </script>
    @push('js')
        <script src="{{ asset('js/Administrador/actividad.js') }}"></script>
    @endpush
    <!-- Meta tags para los mensajes de éxito y error -->
    @if (session('success'))
        <meta name="toast-success" content="{{ session('success') }}">
    @endif
    @if (session('error'))
        <meta name="toast-error" content="{{ session('error') }}">
    @endif
    </div>
@endsection
