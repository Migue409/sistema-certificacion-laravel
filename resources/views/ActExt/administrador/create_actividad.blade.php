@extends('ActExt.layouts.app')

@section('content')
    <div class="container mt-5">
        @if ($errors->has('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>No Disponible:</strong> {{ $errors->first('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2 class="text-center mb-4">Crear Nueva Actividad</h2>

        <div class="card">
            <div class="card-header">
                <h5>Formulario de Actividad</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('actividades.store') }}" method="POST">
                    @csrf <!-- Protección contra CSRF -->

                    <div class="form-group">
                        <label for="actividad">Actividad:</label>
                        <select name="actividad" id="actividad" class="form-control" required>
                            <option value="">Seleccione una actividad</option>
                            <option value="Speaking" {{ old('actividad') == 'Speaking' ? 'selected' : '' }}>Speaking
                            </option>
                            <option value="Asesoría" {{ old('actividad') == 'Asesoría' ? 'selected' : '' }}>Asesoría
                            </option>
                        </select>
                        @error('actividad')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_nivel">Nivel:</label>
                        <select name="id_nivel" id="id_nivel" class="form-control" required>
                            <option value="">Seleccione un nivel</option>
                            @foreach ($niveles as $nivel)
                                <option value="{{ $nivel->id_nivel }}"
                                    {{ old('id_nivel') == $nivel->id_nivel ? 'selected' : '' }}>{{ $nivel->nivel }}</option>
                            @endforeach
                        </select>
                        @error('id_nivel')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value=""
                            required min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                        @error('fecha')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hora">Hora:</label>
                        <select name="hora_display" id="hora_display" class="form-control" required>
                            <option value="">Seleccione una hora</option>
                            @for ($i = 7; $i <= 21; $i++)
                                <!-- Horas de 7 AM a 9 PM -->
                                @php
                                    $amPm = $i < 12 ? 'AM' : 'PM';
                                    $hora12 = $i % 12 == 0 ? 12 : $i % 12;
                                @endphp
                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00">{{ $hora12 }}:00
                                    {{ $amPm }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_usuario">Docente:</label>
                        <select name="id_usuario" id="id_usuario" class="form-control" required>
                            <option value="">Seleccione al docente a cargo</option>
                        </select>
                        @error('id_usuario')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="hora" id="hora" value="{{ old('hora') }}">
                    <!-- Campo oculto para enviar en formato 24h -->

                    <script>
                        document.getElementById('hora_display').addEventListener('change', function() {
                            // Convierte a 24h
                            const selectedHour = this.value;
                            document.getElementById('hora').value = selectedHour;
                        });
                    </script>

                    <div class="form-group">
                        <label for="cupo">Cupo:</label>
                        <input type="number" name="cupo" id="cupo" class="form-control" min="1"
                            max="60" value="{{ old('cupo') }}" required>
                        @error('cupo')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" name="cupo_disponible" id="cupo_disponible" value="0">

                    <div class="form-group">
                        <label for="salon">Salón:</label>
                        <input type="text" name="salon" id="salon" class="form-control" maxlength="100">
                        @error('salon')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr>

                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-success">Crear</button>
                        <a href="{{ route('admin.index') }}" class="btn btn-outline-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ asset('js/Administrador/actividad.js') }}"></script>
    @endpush
@endsection
