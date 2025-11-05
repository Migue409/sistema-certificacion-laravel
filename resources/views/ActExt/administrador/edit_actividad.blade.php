@extends('ActExt.layouts.app') <!-- Asegúrate de que este sea el nombre correcto de tu layout -->

@section('content')
    <div class="container">
        <h1 class="text-center my-4">Editar Actividad</h1> <!-- Título centrado -->

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Contenedor centralizado con borde y estilo profesional -->
        <div class="d-flex justify-content-center">
            <div class="card p-4 shadow" style="max-width: 600px; width: 100%; border-radius: 10px;">
                <form action="{{ route('actividades.update', $actividad->id_actividad) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Método PUT para actualizar -->
                    <input type="hidden" name="id_usuario" value="{{$actividad->id_usuario}}">
                    <div class="mb-3">
                        <label for="actividad" class="form-label">Actividad</label>
                        <input type="text" name="actividad" class="form-control" id="actividad"
                            value="{{ $actividad->actividad }}" required disabled>
                    </div>

                    <div class="mb-3">
                        <label for="id_nivel" class="form-label">Nivel</label>
                        <select name="id_nivel" class="form-select" id="id_nivel" required disabled>
                            @foreach ($niveles as $nivel)
                                <option value="{{ $nivel->id_nivel }}"
                                    {{ $nivel->id_nivel == $actividad->id_nivel ? 'selected' : '' }}>
                                    {{ $nivel->nivel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" id="fecha"
                            value="{{ $actividad->fecha->format('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="hora_display" class="form-label">Hora</label>
                        <select name="hora_display" id="hora_display" class="form-control" required>
                            <option>Seleccione una hora</option>
                            @for ($i = 7; $i <= 21; $i++)
                                @php
                                    $amPm = $i < 12 ? 'AM' : 'PM';
                                    $hora12 = $i % 12 == 0 ? 12 : $i % 12;
                                    $hora24 = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                                @endphp
                                <option value="{{ $hora24 }}"
                                    {{ $hora24 == \Carbon\Carbon::parse($actividad->fecha)->format('H:i') ? 'selected' : '' }}>
                                    {{ $hora12 }}:00 {{ $amPm }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <input type="hidden" name="hora" id="hora"
                        value="{{ \Carbon\Carbon::parse($actividad->fecha)->format('H:i') }}">

                    <script>
                        document.getElementById('hora_display').addEventListener('change', function() {
                            const selectedHour = this.value;
                            document.getElementById('hora').value = selectedHour;
                        });
                    </script>

                    <div class="mb-3">
                        <label for="salon" class="form-label">Salón</label>
                        <input type="text" name="salon" class="form-control" id="salon"
                            value="{{ $actividad->salon }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="cupo" class="form-label">Cupo</label>
                        <input type="number" name="cupo" class="form-control" id="cupo"
                            value="{{ $actividad->cupo }}" min="1" max="60" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                        <a href="{{ route('admin.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
