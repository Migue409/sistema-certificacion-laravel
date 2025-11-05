$(document).ready(function () {
    const tablaResv = document.getElementById('tabResv');
    function cargarReservas(){
        $.ajax({
            url: 'https://coordinacioninglesuttec.com/api/reservas/ajax',
            type: 'GET'
        }).done(function (res) {
           
            var filas = '';
            for (let i = 0; i < res.length; i++) {
                var sentencia = '';
                if (res[i].asistencia) {
                    sentencia = `<span class="badge bg-success">Sí</span>`
                }else{
                    sentencia = `<span class="badge bg-danger">No</span>`
                }
            
                if (res[i].estatus != 'cancelada') {
                    filas += `
                        <tr>
                            <td>`+ res[i].usuario.matricula +`</td>
                            <td>`+ res[i].cita.actividad.fecha +`</td>
                            <td>`+ res[i].cita.actividad.actividad +`</td>
                            <td>
                               `+sentencia+`
                            </td>
                        </tr>
                    `
                }
            }
            tablaResv.innerHTML = filas;
            
        });
    }
    cargarReservas();

    setInterval(cargarReservas, 2000);
});