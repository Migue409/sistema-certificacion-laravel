@extends('ActExt.layouts.app')

@section('content')
<div class="container mt-5 d-flex flex-column align-items-center">
    <h1 class="mb-4 text-center">Buscar Estudiantes</h1>
    <div class="w-100" style="max-width: 500px;">
        <input type="text" id="search-input" placeholder="Escribe las matrículas" class="form-control">
        <div id="resultados" class="list-group"></div> <!-- Contenedor para mostrar resultados -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Información del Estudiante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Matrícula:</strong> <span id="student-matricula"></span></p>
                <p><strong>Nombre:</strong> <span id="student-name"></span></p>
                <p><strong>CURP:</strong> <span id="student-curp"></span></p>
                <p><strong>Nivel:</strong> <span id="student-nivel"></span></p>
                <p><strong>Recurse:</strong> <span id="student-recurse"></span></p>
                <p><strong>División:</strong> <span id="student-division"></span></p>
                <p><strong>Grupo de División:</strong> <span id="student-grupo-division"></span></p>
                <p><strong>Grupo de Inglés:</strong> <span id="student-grupo-ingles"></span></p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
    $('#search-input').on('keyup', function () {
        let query = $(this).val().trim();
        console.log("Query ingresada:", query); // Verificar el valor ingresado

        if (query.length > 2) {
            let matriculas = query.split(' ').filter(matricula => matricula.length > 0);
            console.log("Matrículas procesadas:", matriculas); // Verificar las matrículas divididas

            $.ajax({
                url: '{{ route("buscar.estudiantes") }}',
                method: 'GET',
                data: { matriculas: matriculas },
                success: function(data) {
                    console.log("Respuesta del servidor (buscar.estudiantes):", data); // Ver respuesta

                    $('#resultados').empty();
                    if (data.length) {
                        $.each(data, function(index, estudiante) {
                            $('#resultados').append('<div class="list-group-item" data-id="' + estudiante.matricula + '">' + estudiante.nombre + ' (' + estudiante.matricula + ')</div>');
                        });
                        $('#resultados').show();
                    } else {
                        $('#resultados').hide();
                    }
                }
            });
        } else {
            $('#resultados').hide();
        }
    });

    $('#resultados').on('click', '.list-group-item', function() {
        let matricula = $(this).data('id');
        console.log("Matrícula seleccionada:", matricula); // Verificar matrícula seleccionada

        $.ajax({
            url: '{{ route("buscar.estudiantes.info") }}',
            method: 'GET',
            data: { matricula: matricula },
            success: function(info) {
                console.log("Información del estudiante (buscar.estudiantes.info):", info); // Ver respuesta de información

                $('#student-matricula').text(info.matricula);
                $('#student-name').text(info.nombre);
                $('#student-curp').text(info.curp);
                $('#student-nivel').text(info.nivel);
                $('#student-recurse').text(info.recurse ? 'Sí' : 'No');
                $('#student-division').text(info.division);
                $('#student-grupo-division').text(info.grupo_division);
                $('#student-grupo-ingles').text(info.grupo_ingles);
                
                $('#studentModal').modal('show');
            }
        });
    });
});

</script>
@endsection
