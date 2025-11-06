@extends('layouts.admin')

@section('content')
<!-- resources/views/certificaciones/validar.blade.php -->
<div class="modal" id="validarCertificadoModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Validar Certificado</h5>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('certificados.validar') }}">
          @csrf
          <div class="mb-3">
            <label>Nombre del estudiante:</label>
            <input type="text" name="nombre" class="form-control" value="{{ $certificado->nombre }}" readonly>
          </div>
          <div class="mb-3">
            <label>Matrícula:</label>
            <input type="text" name="matricula" class="form-control" value="{{ $certificado->matricula }}" readonly>
          </div>
          <div class="mb-3">
            <label>Nivel:</label>
            <input type="text" name="nivel" class="form-control" value="{{ $certificado->nivel }}" readonly>
          </div>
          <div class="mb-3">
            <label>Certificado:</label>
            <input type="text" name="archivo" class="form-control" value="{{ $certificado->archivo }}" readonly>
          </div>
          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Validar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
