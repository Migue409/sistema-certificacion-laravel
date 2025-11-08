@extends('ActExt.layouts.estudiante')

@section('title', 'Certificado de Inglés')

@section('content')
<div class="container">
    <h1 class="text-center"><b>Certificado de Inglés</b></h1>

    <div class="d-flex justify-content-between mt-4 mb-3">
        <h2>Mi Certificación</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
            Registrar certificado
        </button>
    </div>

    <table class="table table-bordered">
        <thead style="background-color:#444; color:white;">
            <tr>
                <th>Nombre</th>
                <th>Matrícula</th>
                <th>Grupo</th>
                <th>División</th>
                <th>Nivel</th>
                <th>Certificado</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>
            @if($certificacion)
                <tr>
                    <td>{{ $certificacion->nombre }}</td>
                    <td>{{ $certificacion->matricula }}</td>
                    <td>{{ $certificacion->grupo_ingles }}</td>
                    <td>{{ $certificacion->division }}</td>
                    <td>{{ $certificacion->nivel_in }}</td>
                    <td>{{ $certificacion->certificado }}</td>
                    <td>
                        @if($certificacion->estatus == 'Aprobado')
                            <span class="badge bg-success">Aprobado</span>
                        @elseif($certificacion->estatus == 'Rechazado')
                            <span class="badge bg-danger">Rechazado</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="7" class="text-center">Aún no has registrado ningún certificado.</td>
                </tr>
            @endif
        </tbody>
    </table>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
</div>

<!-- Modal Registrar Certificado -->
<div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalRegistrarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRegistrarLabel">Registrar Certificado</h5>
      </div>
      <form action="{{ route('certificacionEST.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group mb-2">
            <label>Puntaje obtenido:</label>
            <input type="number" name="puntaje" class="form-control" min="0" required>
          </div>

          <div class="form-group mb-2">
            <label>Nivel de inglés obtenido:</label>
            <select name="nivel_in" class="form-control" required>
              <option value="">Seleccione un nivel</option>
              <option value="A1">A1</option>
              <option value="A2">A2</option>
              <option value="B1">B1</option>
              <option value="B2">B2</option>
              <option value="C1">C1</option>
              <option value="C2">C2</option>
            </select>
          </div>

          <div class="form-group mb-2">
            <label>Tipo de certificado:</label>
            <select name="certificado" class="form-control" required>
              <option value="">Seleccione tipo de certificado</option>
              <option>Universidad de Cambridge (PET)</option>
              <option>Universidad de Cambridge (FCE)</option>
              <option>Universidad de Oxford (OTE Oxford Test of English)</option>
              <option>IELTS</option>
              <option>TOEFL (iBT)</option>
              <option>TOEFL (iTP)</option>
              <option>TOEIC</option>
              <option>CENNI</option>
              <option>Trinity ISE</option>
              <option>LinguaSkill</option>
              <option>Otro</option>
            </select>
          </div>

          <div class="form-group mb-2">
            <label>Subir archivo PDF (máx. 5 MB):</label>
            <input type="file" name="archivo" class="form-control" accept="application/pdf" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
