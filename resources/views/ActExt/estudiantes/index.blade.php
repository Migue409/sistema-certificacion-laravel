@extends('ActExt.layouts.estudiante')

@section('content')
<div class="container mt-5"> 
    <!-- Mensaje encima de la tabla -->
    <div class="text-center mb-4">
        <!-- Icono de estudiante y mensaje de información -->
        <i class="fas fa-user-graduate fa-3x text-primary"></i>
        <h3 class="text-dark mt-2"><strong>Información del Estudiante</strong></h3>
        <p class="text-muted">Los datos a continuación corresponden a tu registro académico.</p>
    </div>

    <!-- Tabla horizontal con 2 filas: Títulos y Datos -->
    <div class="table-responsive">
        <table class="table table-bordered" style="border-color: #032859;">
            <thead class="text-white" style="background-color: #032859;">
                <tr>
                    <th class="text-center px-4 py-3">Nombre</th>
                    <th class="text-center px-4 py-3">División</th>
                    <th class="text-center px-4 py-3">Grupo de División</th>
                    <th class="text-center px-4 py-3">Grupo de Inglés</th>
                    <th class="text-center px-4 py-3">Nivel de Inglés</th>
                    <th class="text-center px-4 py-3">Recursador</th>
                </tr>
            </thead>
            <tbody style="background-color: white; color: #333;">
                <tr>
                    <td class="text-center py-3">{{ $estudiante->nombre }}</td>
                    <td class="text-center py-3">{{ $estudiante->datosAcademicos->division ?? 'N/A' }}</td>
                    <td class="text-center py-3">{{ $estudiante->datosAcademicos->grupo_division ?? 'N/A' }}</td>
                    <td class="text-center py-3">{{ $estudiante->datosAcademicos->grupo_ingles ?? 'N/A' }}</td>
                    <td class="text-center py-3">{{ $estudiante->datosAcademicos->nivel ?? 'N/A' }}</td>
                    <td class="text-center py-3">{{ $estudiante->datosAcademicos->recurse == 1 ? 'Sí' : 'No' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
