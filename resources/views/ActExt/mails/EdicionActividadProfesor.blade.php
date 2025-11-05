<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Edición Actividad</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
            <td align="center">
                <!-- Encabezado -->
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: cornflowerblue; padding: 20px;">
                    <tr>
                        <td align="center">
                            <img src="https://i.ibb.co/dwhfCNG4/logo-Coordinacion.png" width="100" height="100" style="border-radius: 50%; display: block;">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="color: white; font-size: 28px; font-weight: bold; padding-top: 10px;">
                            Coordinación de Inglés
                        </td>
                    </tr>
                </table>

                <!-- Contenido -->
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: white; padding: 20px; text-align: center;">
                    <tr>
                        <td style="font-size: 18px; color: #333;">
                            <p>Estimado docente <strong>{{ $docente }}</strong>,</p>
                            <p>Se han modificado algunos datos de la actividad: <strong>{{ $actividad }}</strong>.</p>
                            <p>Las modificaciones se muestran a continuación:</p>
                            <p>Fecha: <strong>{{ $fecha }}</strong></p>
                            <p>Aula: <strong>{{ $aula }}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; color: #555; padding-top: 20px;">
                            <p>Si no se nota ningún cambio en la actividad, favor de hacer caso omiso de este mensaje.</p>
                        </td>
                    </tr>
                </table>

                <!-- Footer -->
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="padding: 20px; text-align: center;">
                    <tr>
                        <td align="center" style="font-size: 14px; color: #888;">
                            © 2024 Coordinación de Inglés. Todos los derechos reservados.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
