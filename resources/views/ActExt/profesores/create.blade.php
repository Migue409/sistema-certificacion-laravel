@extends('ActExt.layouts.app')

@section('title', 'Agregar Profesor')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Agregar Profesor</h1>

            <form action="{{ route('profesores.store') }}" method="POST">
                @csrf <!-- Token de protección contra CSRF -->
                <div class="mb-3">
                    <label for="matricula" class="form-label">Matrícula</label>
                    <input type="text" class="form-control" id="matricula" name="matricula" required>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="mb-3">
                    <label for="curp" class="form-label">CURP</label>
                    <input type="text" class="form-control" id="curp" name="curp" required>
                </div>

                <div class="mb-3">
                    <label for="curp" class="form-label">Correo electrónico</label>
                    <input type="text" class="form-control" id="correo" name="correo" required>
                </div>

                <button type="submit" class="btn btn-outline-success">Agregar</button>
                <a href="{{ route('profesores.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection