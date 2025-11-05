@extends('ActExt.layouts.app')



@section('title', 'Registro de Asistencias')



@section('content')

    @if (session('danger'))
        <div class="alert alert-danger">

            {{ session('danger') }}

        </div>
    @endif

    <div class="container">

        <h1 class="text-center mb-4"><b>Listas de alumnos registrados para TeamTask</b></h1>

        <input type="hidden" id="id_act" name="" value="">

        <a href="{{ route('exportar.registrosTeamTask') }}" class="btn btn-lg btn-success mb-3">

            <i class="fa-solid fa-file-excel"></i> Exportar a XLS (Total)

        </a>

        <a href="{{ route('exportar.registrosTeamTaskActual') }}" class="btn btn-lg btn-success mb-3">

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

                    <th>¿Cumple con los requisitos?</th>

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

                        <td>{{ $reg->requisitos }}</td>

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
