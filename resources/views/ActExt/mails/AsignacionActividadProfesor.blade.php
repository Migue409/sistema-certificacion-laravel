<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación de Actividad</title>
</head>
<body style="margin: 0; padding: 20px; background-color: #f4f4f4; font-family: Arial, sans-serif;">

    <table width="100%" style="max-width: 600px; margin: auto; background-color: #6495ED; padding: 20px; border-radius: 10px;">
        <tr>
            <td align="center">
                <img src="https://i.ibb.co/dwhfCNG4/logo-Coordinacion.png" alt="Logo" style="width: 120px; height: 120px; border-radius: 50%;">
            </td>
        </tr>
        <tr>
            <td align="center">
                <h1 style="color: white; font-size: 32px; margin-top: 20px;">Coordinación de Inglés</h1>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="background-color: white; padding: 20px; border-radius: 10px;">
                    <tr>
                        <td align="center">
                            <h3 style="color: #333;">Estimado docente <strong>{{$docente}}</strong></h3>
                            <h3 style="color: #333;">Se le ha asignado una actividad extracurricular de tipo: <strong>{{$actividad}}</strong></h3>
                            <h3 style="color: #333;">El día <strong>{{$fecha}}</strong> en el Aula <strong>{{$aula}}</strong></h3>
                            <br>
                            <h4 style="color: #555;">Si tiene alguna duda, pase a la oficina de Coordinación de Inglés.</h4>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
