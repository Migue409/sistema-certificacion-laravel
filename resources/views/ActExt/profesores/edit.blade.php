@extends('ActExt.layouts.app')

@section('title', 'Editar Profesor')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Editar Profesor</h1>

    <form action="{{ route('profesores.update', $profesor->id_usuario) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="matricula" value="{{ $profesor->matricula }}" required disabled>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $profesor->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="curp" class="form-label">CURP</label>
            <input type="text" class="form-control" id="curp" name="curp" value="{{ $profesor->curp }}" required>
        </div>

        <button type="submit" class="btn btn-outline-success">Actualizar</button>
        <a href="{{ route('profesores.index') }}" class="btn btn-outline-danger">Cancelar</a>
    </form>
</div>
@endsection