@extends('ActExt.layouts.app') <!-- Asegúrate de que este sea el nombre correcto de tu layout -->

@section('title', 'Certificación de Inglés')  <!-- Título de la página -->

@section('content')
    <div class="container">
          <h1>
                <center><b>Panel de Certificación de Inglés</b></center>
          </h1>

          <div class="container mt-3">
            <h2 class="mb-2">Lista de certificados</h2>
            
          <!--Botón para exportar en excel los registros de los aspirantes y para generar dictamen -->

                <a class="btn btn-success btn-lg mb-3">Exportar en Excel</a>
                <a class="btn btn-success btn-lg mb-3">Generar dictamen</a>

            <table class="table table-bordered">
              <thead class="table-dark">
                <tr>
                  <th>Nombre</th>
                  <th>Matrícula</th>
                  <th>Correo</th>
                  <th>División</th>
                  <th>Grupo</th>
                  <th>Nivel</th>
                  <th>Certificado</th>
                  <th>Estatus</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($certificados as $cert)
                <tr>
                  <td>{{ $cert->nombre }}</td>
                  <td>{{ $cert->matricula }}</td>
                  <td>{{ $cert->correo }}</td>
                  <td>{{ $cert->division }}</td>
                  <td>{{ $cert->grupo }}</td>
                  <td>{{ $cert->nivel }}</td>
                  <td>{{ $cert->archivo }}</td>
                  <td>{{ $cert->estatus }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endsection