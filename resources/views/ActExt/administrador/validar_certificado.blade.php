@extends('layouts.admin')

@section('content')
<div class="modal-dialog-centered">
  <div class="card shadow p-4">
    <h3 class="mb-4 text-center">Validar Certificado</h3>

    <form method="POST" action="{{ route('admin.certificacion.ingles.validar.post') }}">
      @csrf
      <input type="hidden" name="id" value="{{ $certificado->id }}">

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
        <a href="{{ route('admin.certificacion.ingles') }}" class="btn btn-danger">Cancelar</a>
      </div>
    </form>
  </div>
</div>
@endsection
