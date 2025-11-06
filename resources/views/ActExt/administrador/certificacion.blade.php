@extends('ActExt.layouts.app') <!-- Extiende el layout base -->

@section('title', 'Certificación de Inglés') <!-- Título de la página -->

@section('content')
<!-- Modal Validar Certificado -->
<div class="modal fade" id="modalDictamen" tabindex="-1" aria-labelledby="modalDictamenLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDictamenLabel">Validar Certificado</h5>
      </div>
      <div class="modal-body">
        <form id="formDictamen">
          @csrf
          <input type="hidden" id="id_usuario">

          <div class="form-group mb-2">
            <label>Nombre del estudiante:</label>
            <input type="text" id="nombre" class="form-control" readonly>
          </div>
          <div class="form-group mb-2">
            <label>Matrícula:</label>
            <input type="text" id="matricula" class="form-control" readonly>
          </div>
          <div class="form-group mb-2">
            <label>Nivel:</label>
            <input type="text" id="nivel" class="form-control" readonly>
          </div>
          <div class="form-group mb-2">
            <label>Certificado:</label>
            <input type="text" id="certificado" class="form-control" readonly>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnValidar" class="btn btn-success">Validar</button>
        <button type="button" id="btnRechazar" class="btn btn-danger">Rechazar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
   

    <h1>
            <center><b>Panel de Certificación de Inglés</b></center>
        </h1>

        <div class="activity-list mt-3">
            <div class="d-flex justify-content-between">
                <h2>Lista de certificados</h2>

        <div>
            <a href="{{ route('certificacion.exportar') }}" class="btn btn-success mr-2">Exportar en Excel</a>
            <a id="btnDictamen" href="#" class="btn btn-success" style="background-color:#90EE90; border-color:#90EE90;" disabled>Generar dictamen</a>
        </div>
    </div>

    <table class="table table-bordered">
        <thead style="background-color:#444; color:white;">
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
 <tbody>
    @forelse($certificados as $certificado)
        <tr class="fila-certificacion" 
            data-id="{{ $certificado->id_usuario }}" 
            data-nombre="{{ $certificado->nombre }}"
            data-matricula="{{ $certificado->matricula }}"
            data-nivel="{{ $certificado->nivel }}"
            data-certificado="{{ $certificado->certificado }}">
            <td>{{ $certificado->nombre }}</td>
            <td>{{ $certificado->matricula }}</td>
            <td>{{ $certificado->correo }}</td>
            <td>{{ $certificado->division }}</td>
            <td>{{ $certificado->grupo }}</td>
            <td>{{ $certificado->nivel }}</td>
            <td>{{ $certificado->certificado }}</td>
            <td>{{ $certificado->estatus }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">No hay certificados disponibles.</td>
        </tr>
    @endforelse
</tbody>
    </table>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</div>
@endsection

<script>
let selected = null;

document.querySelectorAll('.fila-certificacion').forEach(row => {
    row.addEventListener('click', () => {
        selected = {
            id: row.dataset.id,
            nombre: row.dataset.nombre,
            matricula: row.dataset.matricula,
            nivel: row.dataset.nivel,
            certificado: row.dataset.certificado
        };

        // Activar botón
        const btn = document.getElementById('btnDictamen');
        btn.disabled = false;
        btn.style.backgroundColor = '#28a745'; // verde fuerte
        btn.style.borderColor = '#28a745';
    });
});

document.getElementById('btnDictamen').addEventListener('click', (e) => {
    e.preventDefault();
    if (!selected) return;

    // Llenar modal
    document.getElementById('id_usuario').value = selected.id;
    document.getElementById('nombre').value = selected.nombre;
    document.getElementById('matricula').value = selected.matricula;
    document.getElementById('nivel').value = selected.nivel;
    document.getElementById('certificado').value = selected.certificado;

    // Mostrar modal
    new bootstrap.Modal(document.getElementById('modalDictamen')).show();
});

document.getElementById('btnValidar').addEventListener('click', () => {
    procesarDictamen('validar');
});

document.getElementById('btnRechazar').addEventListener('click', () => {
    procesarDictamen('rechazar');
});

function procesarDictamen(accion) {
    fetch(`/certificacion/${selected.id}/${accion}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    })
    .catch(err => console.error(err));
}
</script>
