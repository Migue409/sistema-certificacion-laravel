<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de cita</title>
    <style>
        * {
            font-family: "Oswald", serif;
            font-optical-sizing: auto;
            font-style: bold;
        }

        .fondoCarta {
            background-color: cornflowerblue;
            width: 90%;
            min-height: 80vh;
            padding: 1rem;
            box-sizing: border-box;
        }

        .fondoMensaje {
            background-color: white;
            width: 90%;
            min-height: 55vh;
            padding: 1rem;
            margin-top: 10px;
            box-sizing: border-box;
        }

        .logo {
            width: 40%;
            min-height: 10vh;
            box-sizing: border-box;
            border-radius: 50%;
        }

        .titulo {
            margin-top: 8vh;
            font-size: 90px;
            color: white;
        }

        /* Estilo de los enlaces */
        a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <main style="text-align: center; margin-top: 20px; padding: 20px;">
        <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
            <div style="flex: 1; text-align: center; padding-right: 20px;">
                <img src="https://i.ibb.co/dwhfCNG4/logo-Coordinacion.png" alt="Logo" class="logo">
            </div>
            <div style="flex: 2; text-align: center;">
                <h1 class="titulo">Coordinación de Inglés</h1>
            </div>
        </div>

        <div class="fondoMensaje" style="background-color: white; width: 90%; padding: 20px; text-align: center;">
            <h3>Estimad@ <strong>{{$nombre}}</strong></h3>
            <h3 class="mt-3">Se ha modificado tu cita para la actividad extracurricular: <strong>{{$actividad}}</strong></h3>
            <h3>Las modificaciones son las siguientes:</h3>
            <h3>El día <strong>{{$fecha}}</strong> en el Aula <strong>{{$aula}}</strong></h3>
            <h3>Con el docente: <strong>{{$docente}}</strong></h3>
            <br><br><br><br>
            <h4>De parte de la Coordinación de Inglés te deseamos éxito en tus actividades.</h4>
            <br><br>
            <h5>Si no ves ningún cambio en tu cita, haz caso omiso a este mensaje.</h5>
        </div>
    </main>
</body>
</html>
