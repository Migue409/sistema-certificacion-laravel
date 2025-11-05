@extends('ActExt.layouts.app') <!-- Extiende el layout base -->

@section('title', 'Concentrado de Excel') <!-- Título de la página -->

@section('content')
<div class="container">
    <h1 class="text-center mb-4"><b>Concentrado de Excel</b></h1>

    <div class="card shadow-sm p-4 mb-4 mx-auto" style="max-width: 600px; border: 1px solid #ced4da; border-radius: 8px;">
        <div class="text-center">
            <label for="excel" class="form-label"><b>Descargar excel .CSV (formato en blanco)</b></label>
            <div class="mb-3">
                <a href="{{ route('download') }}" class="btn btn-outline-success">
                    <i class="fas fa-file-excel"></i> Descargar
                </a>
            </div>
            <hr>
            <form action="{{ route('concentrado.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- Token de seguridad -->
                <div class="mb-3">
                    <label for="archivo" class="form-label"><b>Agregar/Actualizar estudiantes (Importar)</b></label>
                    <div class="input-group" style="justify-content: center;">
                        <input type="file" name="file" class="form-control" style="max-width: 80%;" required>
                    </div>
                </div>
                <div class="mt-4"> <!-- Añadir margen superior -->
                    <button type="submit" class="btn btn-outline-primary">Subir Archivo</button>
                </div>
                
                <!-- Mensajes de error o éxito -->
                @if ($errors->any())
                    <div class="alert alert-danger mt-2">
                        {{ $errors->first() }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success mt-2">
                        {{ session('success') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection