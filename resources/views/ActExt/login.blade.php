@extends('ActExt.layouts.login')

@section('content')

<div class="card shadow-sm p-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary text-center">Inicio de Sesión</h2> <!-- Añadí text-center aquí -->
    </div>
    <form action="{{ route('login') }}" method="POST" id="loginForm">
        @csrf

        <!-- Floating label para Matrícula -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Matrícula" required>
            <label for="matricula">Matrícula</label>
        </div>

        <!-- Floating label para CURP -->
        <div class="form-floating mb-4">
            <input type="text" class="form-control" id="curp" name="curp" maxlength="4" placeholder="Primeros 4 caracteres del CURP" required>
            <label for="curp">Primeros 4 caracteres del CURP</label>
        </div>

        <!-- Botón de inicio de sesión -->
        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">Iniciar Sesión</button>
        <center><br><a href="{{route('estudiantes.registro')}}">¿Aún no estas registrado? Registrate aquí.</a></center>
    </form>
</div>
@if(session('success'))
<meta name="toast-success" content="{{ session('success') }}">
@endif
@if(session('error'))
<meta name="toast-error" content="{{ session('error') }}">
@endif
</body>

</html>

@endsection