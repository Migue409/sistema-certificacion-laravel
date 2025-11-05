@extends('ActExt.layouts.app')

@section('title', 'Gestión de Profesores')

@section('content')
@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
<div class="container">
    <h1 class="text-center mb-4">Gestión de Profesores</h1>

    <a href="{{ route('profesores.create') }}" class="btn btn-success mb-3">Agregar Profesor</a>

    @if ($profesores->isEmpty())
        <div class="alert alert-warning" role="alert">
            No hay profesores registrados.
        </div>
    @else
        <table class="table table-dark">
            <thead>
                <tr>
                    <!-- Se omite la cabecera del ID para que no se muestre visualmente -->
                    <th>Nombre</th>
                    <th>CURP</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profesores as $profesor)
                    <tr>
                        <!-- Campo ID oculto con estilo CSS -->
                        <td style="display: none;">{{ $profesor->id_usuario }}</td>
                        <td>{{ $profesor->nombre }}</td>
                        <td>{{ $profesor->curp }}</td>
                        <td>
                            <a href="{{ route('profesores.edit', $profesor->id_usuario) }}" class="btn btn-warning">Editar</a>
                            <form action="{{route('eliminar.profe',$profesor->id_usuario)}}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?');">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection