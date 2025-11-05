$(document).ready(function () {
    const tablaActs = document.getElementById('tabActs');
    const comboDoc = document.getElementById('id_usuario'); 
    function cargar_actividades() {
        $.ajax({
            url: 'https://coordinacioninglesuttec.com/api/actividadesProfesor',
            type: 'GET',
            dataType: 'json'
        }).done(function(response) {
            let data = [];
            let fechaActual = new Date();
            let fechaFormateada = fechaActual.toISOString().split('T')[0]; // YYYY-MM-DD
    
            response.forEach(actividad => {
                let fecha = formatFecha(actividad.fecha);
                let fechaBD = actividad.fecha.substring(0, 10);
                let urlAsistencias = asistenciasRoute.replace(':id', actividad.id_actividad);
    
                let accion = actividad.cupo == 0 ? 
                    `<div>Cancelada</div>` :
                    (fechaFormateada == fechaBD ? 
                        `<a href="${urlAsistencias}" class="btn btn-light btn-sm">Tomar asistencias</a>` :
                        `<button class="btn btn-secondary btn-sm" title="Aún no puedes registrar las asistencias">Tomar asistencias</button>`
                    );
    
                data.push([
                    actividad.id_actividad,
                    actividad.actividad,
                    fecha,
                    actividad.salon,
                    actividad.cupo,
                    actividad.cupo_disponible,
                    `<div class="d-flex flex-column flex-md-row gap-2 justify-content-center">${accion}</div>`
                ]);
            });
    
            // Verificar si la tabla ya está inicializada
            if ($.fn.DataTable.isDataTable('#tablaActividades')) {
                let table = $('#tablaActividades').DataTable();
                table.clear().rows.add(data).draw(); // Solo actualizar datos sin recargar
            } else {
                // Inicializar DataTable si aún no está creada
                $('#tablaActividades').DataTable({
                    data: data,
                    columns: [
                        { title: "ID" },
                        { title: "Actividad" },
                        { title: "Fecha" },
                        { title: "Salón" },
                        { title: "Cupo" },
                        { title: "Cupo Disponible" },
                        { title: "Acciones", orderable: false }
                    ],
                    responsive: true,
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json"
                    }
                });
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error al cargar actividades:", textStatus, errorThrown);
        });
    }
    
    // **Actualizar cada 10 segundos sin recargar toda la página**
    setInterval(cargar_actividades, 2000);
    
    // Cargar la tabla al inicio
    cargar_actividades();
    

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


   

});