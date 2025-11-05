<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelación de actividad</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600px" cellspacing="0" cellpadding="0" border="0" style="background-color: white; padding: 20px; border-radius: 5px;">
                    <tr>
                        <td align="center">
                            <img src="https://i.ibb.co/dwhfCNG4/logo-Coordinacion.png" width="100" alt="Logo Coordinación" style="display: block; margin: 0 auto;">
                            <h1 style="color: #2c3e50; font-family: Arial, sans-serif; text-align: center;">Coordinación de Inglés</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; text-align: center; font-family: Arial, sans-serif;">
                            <p style="font-size: 18px; color: #333;">Estimado docente <strong>{{ $docente }}</strong>,</p>
                            <p style="font-size: 16px; color: #555;">Se ha cancelado la actividad extracurricular:</p>
                            <p style="font-size: 18px; font-weight: bold; color: #e74c3c;">{{ $actividad }}</p>
                            <p style="font-size: 16px; color: #555;">El día <strong>{{ $fecha }}</strong> en el Aula <strong>{{ $aula }}</strong></p>
                            <hr style="border: 0; height: 1px; background: #ddd; margin: 20px 0;">
                            <p style="font-size: 14px; color: #777;">Manténgase al tanto por si se le reasigna una nueva actividad.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
