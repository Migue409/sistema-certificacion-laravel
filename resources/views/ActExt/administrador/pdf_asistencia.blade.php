<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <title>Lista de asistencia</title>
    <style>
        * {
            font-family: "Oswald", serif;
            font-optical-sizing: auto;
            font-style: bold;
        }

        .logo {
            width: 40%;
            min-height: 10vh;
            box-sizing: border-box;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <main class="container mt-4">
        <table>
            <tr>
                <td><img src="' . $logoBase64 . '" class="logo" alt="Logo"></td>
                <td><h1>LISTA DE ASISTENCIAS</h1></td>
            </tr>
        </table>
        <div class="row mb-3">
            <div class="col-md-3">
                <img src="{{ asset('images/logoCoordinacion.png') }}" class="logo ms-3 mt-3" alt="">
            </div>
            <div class="col-md-6 mt-5 text-center">
                <h1>LISTA DE ASISTENCIAS</h1>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered  border-dark table-sm">
                <tr>
                    <td><strong>Actividad:</strong></td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td><strong>Docente a cargo:</strong></td>
                    <td colspan="4">asd</td>
                </tr>
                <tr>
                    <td><strong>Fecha y hora:</strong></td>
                    <td>asdasd</td>
                    <td colspan="2"><strong>Aula:</strong></td>
                    <td>asd</td>
                </tr>
                <tr>
                    <td>Matrícula</td>
                    <td>Nombre</td>
                    <td colspan="3">Asistencia </td>
                </tr>
                {{-- espacio dinamico --}}
                <tr>
                    <td>2522160002</td>
                    <td>Alan Adair Vazquez Cruz</td>
                    <td style="background-color: green"></td>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td>2522160002</td>
                    <td>Alan Adair Vazquez Cruz</td>
                    <td colspan="2"></td>
                    <td style="background-color: red"></td>
                </tr>

            </table>
        </div>
    </main>
</body>

</html>
