$(document).ready(function () {
    const tablaAsis = document.getElementById('tabAsis');
    console.log(idGet);

    function cargarAsistencias(id) {
        $.ajax({
            url: 'https://coordinacioninglesuttec.com/api/actividades/' + id + '/asistencias/ajax',
            type: 'GET'
        }).done(function (res) {
            var filas = '';
            for (let i = 0; i < res.reservaciones.length; i++) {
                filas += `
                    <tr>
                        <input type="hidden" name="id_estudiante[`+ res.reservaciones[i].id +`]"
                            value="`+ res.reservaciones[i].usuario.id_usuario +`">
                        <td>`+ res.reservaciones[i].usuario.nombre +`</td>
                        <td>`+ res.reservaciones[i].usuario.matricula +`</td>
                        <td>
                            <!-- Usar radio buttons para seleccionar asistencia -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="asistencias[`+ res.reservaciones[i].id +`]" value="asistio" required>
                                <label class="form-check-label">Asistió</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                    name="asistencias[`+ res.reservaciones[i].id +`]" value="no_asistio" required>
                                <label class="form-check-label">No Asistió</label>
                            </div>
                            
                        </td>
                    </tr>
                `
            }
            tablaAsis.innerHTML = filas;
        });
    }

    cargarAsistencias(idGet);

    setInterval(function() {
        cargarAsistencias(idGet);
    }, 100000);
    
});