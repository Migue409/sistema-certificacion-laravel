@extends('ActExt.layouts.profesor')

@section('content')
    <div class="container">
        <h1>
            <center><b>Actividades asignadas</b></center>
        </h1>

        <div class="activity-list mt-3">
            <div class="d-flex justify-content-between">
                <h2>Actividades</h2>
                
            </div>
            <hr>
            @if ($actividades->isEmpty())
                <div class="alert alert-warning" role="alert">
                    Aún no se tienen actividades asignadas.
                </div> 
            @else
                <!-- Hacer la tabla responsive en dispositivos pequeños -->
                <div class="table-responsive">
                    <table class=" display table table-dark table-hover table-bordered table-striped align-middle" id="tablaActividades" 
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Actividad</th>
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
        <script>
            const csrfToken = "{{ csrf_token() }}";
            var asistenciasRoute = "{{ route('actividades.asistencias', ':id') }}";
        </script>
        @push('js')
            <script src="{{ asset('js/Profesor/actividad.js') }}"></script>
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
