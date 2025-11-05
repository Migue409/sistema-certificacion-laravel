@extends('ActExt.layouts.estudiante')

@section('title', 'Certificación de Inglés')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h1>Certificado de Inglés</h1>
    </div>

    <!-- Botón para registrar nuevo certificado -->
    <div class="text-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistrarCertificado">
            Registrar certificado
        </button>
    </div>

    {{-- Tabla de certificados del estudiante --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Matrícula</th>
                    <th>Grupo</th>
                    <th>División</th>
                    <th>Nivel</th>
                    <th>Certificado</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($certificaciones as $certificaciones)
                    <tr>
                        <td>{{ $certificaciones->nombre }}</td>
                        <td>{{ $certificaciones->matricula }}</td>
                        <td>{{ $certificaciones->grupo }}</td>
                        <td>{{ $certificaciones->division }}</td>
                        <td>{{ $certificaciones->nivel }}</td>
                        <td>
                            <a href="{{ asset('storage/certificados/' . $certificado->archivo) }}" target="_blank" class="btn btn-primary btn-sm">
                                Ver PDF
                            </a>
                        </td>
                        <td>
                            @if ($certificaciones->estatus === 'Pendiente')
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @elseif ($certificaciones->estatus === 'Aprobado')
                                <span class="badge bg-success">Aprobado</span>
                            @elseif ($certificaciones->estatus === 'Rechazado')
                                <span class="badge bg-danger">Rechazado</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted">Aún no has subido ningún certificado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


</div>
@endsection
