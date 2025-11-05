@extends('ActExt.layouts.app')



@section('title', 'Registro de Asistencias')



@section('content')

    @if (session('danger'))
        <div class="alert alert-danger">

            {{ session('danger') }}

        </div>
    @endif

    <div class="container">

        <h1 class="text-center mb-4"><b>Listas de alumnos registrados para Recurse en Educación Continua</b></h1>

        <input type="hidden" id="id_act" name="" value="">

        <a href="{{ route('exportar.registrosRecurseEC') }}" class="btn btn-lg btn-success mb-3">

            <i class="fa-solid fa-file-excel"></i> Exportar a XLS (Total)

        </a>

        <a href="{{ route('exportar.registrosRecurseECActual') }}" class="btn btn-lg btn-success mb-3">

            <i class="fa-solid fa-file-excel"></i> Exportar a XLS (Solo cuatrimestre actual)

        </a>



        <table class="table table-bordered table-hover table-striped text-center">

            <thead class="table-dark">

                <tr>

                    <th>Nombre</th>

                    <th>Matrícula</th>

                    <th>Correo</th>

                    <th>Teléfono</th>

                    <th>División</th>

                    <th>Grupo División</th>

                    <th>Grupo de Inglés Regular</th>

                    <th>Asignatura de Recurse</th>

                    <th>Nivel</th>

                    <th>Cuatrimestre</th>
                </tr>

            </thead>

            <tbody>

                @foreach ($registros as $reg)
                    <tr>

                        <td>{{ $reg->nombre . ' ' . $reg->apellidoP . ' ' . $reg->apellidoM }}</td>

                        <td>{{ $reg->matricula }}</td>

                        <td>{{ $reg->correo }}</td>

                        <td>{{ $reg->telefono }}</td>

                        <td>{{ $reg->division }}</td>

                        <td>{{ $reg->grupoDivision }}</td>

                        <td>{{ $reg->grupoInglesReg }}</td>

                        <td>{{ $reg->grupoInglesRec }}</td>

                        <td>{{ $reg->nivel }}</td>

                        <td>{{ $reg->cuatrimestre }}</td>

                    </tr>
                @endforeach

            </tbody>

        </table>
        <div class="d-flex justify-content-center">
            {{ $registros->links('pagination::bootstrap-4') }}
        </div>
    </div>

@endsection
