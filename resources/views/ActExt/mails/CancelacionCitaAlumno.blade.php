<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelación de cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: cornflowerblue;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            color: white;
        }
        .logo {
            max-width: 100px;
            border-radius: 50%;
        }
        .content {
            text-align: center;
            padding: 20px;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://i.ibb.co/dwhfCNG4/logo-Coordinacion.png" class="logo" alt="Coordinación de Inglés">
            <h1>Coordinación de Inglés</h1>
        </div>
        <div class="content">
            <p>Estimado <strong>{{$nombre}}</strong>,</p>
            <p>Has cancelado tu cita para la actividad extracurricular: <strong>{{$actividad}}</strong>.</p>
            <p>Fecha: <strong>{{$fecha}}</strong></p>
            <p>Aula: <strong>{{$aula}}</strong></p>
            <p>Docente: <strong>{{$docente}}</strong></p>
            <p>De parte de la Coordinación de Inglés te deseamos éxito en tus actividades y esperamos volver a verte pronto.</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Coordinación de Inglés. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>