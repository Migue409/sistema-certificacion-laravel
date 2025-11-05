$(document).ready(function () {
    const combo = document.getElementById("hora_display");
    const tablaActs = document.getElementById('tabActs');
    const comboDoc = document.getElementById('id_usuario');
    var table; // Declaramos la variable para la tabla

    function cargar_actividades() {
        // Realiza la solicitud AJAX
        $.ajax({
            url: "https://coordinacioninglesuttec.com/api/admin/dashboard/ajax",
            type: "GET",
            success: function (actividades) {
                // Verificamos si la tabla ya está inicializada
                if ($.fn.dataTable.isDataTable('#tabActs')) {
                    table = $('#tabActs').DataTable();
                } else {
                    // Si no está inicializada, la inicializamos
                    table = $('#tabActs').DataTable({
                        "language": {
                            "url": "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json"
                        },
                        "destroy": true, // Para reinicializar DataTable si ya existe
                        "processing": true,
                        "serverSide": false,
                        "columns": [
                            { "data": "id_actividad" },
                            { "data": "actividad" },
                            { "data": null, "render": function (data, type, row) { return row.nombre ?? 'N/A'; } },
                            { "data": "fecha", "render": function (data) { return formatFecha(data); } },
                            { "data": "salon" },
                            { "data": "cupo" },
                            { "data": "cupo_disponible" },
                            {
                                "data": null, "render": function (data, type, row) {
                                    let urlCancelar = cancelarReservasRoute.replace(':id', row.id_actividad);
                                    let urlEditar = editarRoute.replace(':id', row.id_actividad);
                                    let urlAsistencias = asistenciasRoute.replace(':id', row.id_actividad);

                                    let acciones = `<a href="${urlAsistencias}" class="btn btn-light btn-sm">Lista de asistencias</a>`;

                                    if (fechasFuturas(row.fecha) && row.cupo_disponible > 0) {
                                        acciones += `
                                    <a href="${urlEditar}" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="${urlCancelar}" method="POST" style="display: inline;">
                                        <input type="hidden" name="_token" value="${csrfToken}">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Cancelar todas las reservaciones?')">Cancelar</button>
                                    </form>
                                `;
                                    }
                                    return acciones;
                                }
                            }
                        ],
                    });
                }

                // Limpia las filas actuales y agrega las nuevas
                table.clear().rows.add(actividades).draw();
            },
            error: function () {
                console.log("Error al cargar actividades");
            }
        });
    }
    cargar_actividades();

    // Llamamos a la función cada 2 segundos
    setInterval(cargar_actividades, 2000);


    function formatFecha(fechaStr) {
        let fecha = new Date(fechaStr);
        let dia = fecha.getDate().toString().padStart(2, '0');
        let mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Mes empieza en 0
        let año = fecha.getFullYear();
        let horas = fecha.getHours().toString().padStart(2, '0');
        let minutos = fecha.getMinutes().toString().padStart(2, '0');

        return `${dia}/${mes}/${año} ${horas}:${minutos}`;
    }

    function fechasFuturas(fecha) {
        const ahora = new Date();
        const formato = ahora.toISOString().split('T')[0]; // Obtiene YYYY-MM-DD

        const [date, time] = fecha.split(" ");
        const [year, month, day] = date.split("-");

        const fechaBD = year + '-' + month + '-' + day

        if (fechaBD > formato) {
            return 'ok'
        }
    }
    

    combo.addEventListener("change", function () {
        
        var fecha = document.getElementById('fecha').value;
        var hora = document.getElementById("hora_display").value;

        $.ajax({
            url: 'https://coordinacioninglesuttec.com/api/ajax/docente/' + fecha + '/' + hora,
            type: 'GET'
        }).done(function (res) {
            console.log(res);
            if (res.length == 0) {
                var comboBox = `<option value="" style="color: red;">No hay docentes disponibles en este horario</option>`;
            } else {
                var comboBox = `<option value="">Seleccione al docente a cargo</option>`;
                for (let i = 0; i < res.length; i++) {
                    comboBox += `
                    <option value="`+ res[i].id_usuario + `">` + res[i].nombre + `</option>'
                    `;
                }
            }

            comboDoc.innerHTML = comboBox;

        });
    });



});