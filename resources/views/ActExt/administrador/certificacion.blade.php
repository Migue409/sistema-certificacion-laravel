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
            <button id="btnDictamen" class="btn btn-success" disabled style="background-color:#90EE90; border-color:#90EE90;">Generar dictamen</button>
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
            data-nivel="{{ $certificado->nivel_in }}"
            data-certificado="{{ $certificado->certificado }}">
            <td>{{ $certificado->nombre }}</td>
            <td>{{ $certificado->matricula }}</td>
            @php
                $mensaje = $certificado->estatus === 'Aprobado'
                ? "Estimado {$certificado->nombre},%0A%0ASu certificación ha sido validada exitosamente.%0A%0AFelicidades.%0A%0AAtentamente,%0ACoordinación de Inglés."
                : "Estimado {$certificado->nombre},%0A%0ALamentamos informarle que su certificación fue rechazada.%0A%0AAtentamente,%0ACoordinación de Inglés.";
            @endphp
                <td>
                    <a href="mailto:{{ $certificado->correo }}?subject=Resultado de certificación&body={{ $mensaje }}">
                        {{ $certificado->correo }}
                    </a>
                </td>
            <td>{{ $certificado->division }}</td>
            <td>{{ $certificado->grupo_ingles }}</td>
            <td>{{ $certificado->nivel_in }}</td>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filas = document.querySelectorAll('.fila-certificacion');
    const btnDictamen = document.getElementById('btnDictamen');
    let selected = null;

    filas.forEach(row => {
        row.addEventListener('click', function () {
          const estatus = this.cells[7].textContent.trim(); // Columna 'Estatus'

            // Si la misma fila se vuelve a hacer clic → deselecciona
            if (selected === this) {
                this.classList.remove('table-primary');
                selected = null;
                btnDictamen.disabled = true;
                btnDictamen.style.backgroundColor = '#90EE90';
                btnDictamen.style.borderColor = '#90EE90';
                return;
            }

            // Quita selección anterior (si había otra)
            if (selected) selected.classList.remove('table-primary');

            // Selecciona la nueva fila
            this.classList.add('table-primary');
            selected = this;

            
            // Activa el botón
            btnDictamen.disabled = false;
            btnDictamen.style.backgroundColor = '#198754';
            btnDictamen.style.borderColor = '#198754';
        });
    });

    // Al presionar "Generar dictamen"
    btnDictamen.addEventListener('click', e => {
        e.preventDefault();
        if (!selected) return;

        const datos = {
            id: selected.dataset.id,
            nombre: selected.dataset.nombre,
            matricula: selected.dataset.matricula,
            nivel: selected.dataset.nivel,
            certificado: selected.dataset.certificado
        };

        // Llenar modal
        document.getElementById('id_usuario').value = datos.id;
        document.getElementById('nombre').value = datos.nombre;
        document.getElementById('matricula').value = datos.matricula;
        document.getElementById('nivel').value = datos.nivel;
        document.getElementById('certificado').value = datos.certificado;

        // Mostrar modal
        new bootstrap.Modal(document.getElementById('modalDictamen')).show();
    });

    document.getElementById('btnValidar').addEventListener('click', () => procesarDictamen('validar'));
    document.getElementById('btnRechazar').addEventListener('click', () => procesarDictamen('rechazar'));

    function procesarDictamen(accion) {
    if (!selected) return;

    fetch(`/certificacion/aprobar/${selected.dataset.id}/${accion}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);

        if (accion === 'validar') {
            //  Genera el PDF en una pestaña nueva
            const url = `/certificacion/dictamen/${selected.dataset.id}`;
            const win = window.open(url, '_blank'); // abrir PDF en nueva pestaña

            //  Espera un momento y recarga la tabla
            setTimeout(() => {
                location.reload();
            }, 2500);
        } else {
            // Si es "rechazar", recarga normalmente
            location.reload();
        }
    })
        .catch(err => console.error(err));
    }
});
</script>
@endpush


