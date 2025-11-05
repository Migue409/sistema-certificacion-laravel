<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="shortcut icon" href="{{ asset('images/logoCoordinacion.png') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
    <style>
        /* Estilo general para el contenedor del formulario */
        .card {
            max-width: 500px;
            /* Ancho máximo en PC */
            margin: 0 auto;
            /* Centrado automático */
        }

        /* Estilo para hacer que el formulario sea más ancho en pantallas grandes */
        @media (min-width: 992px) {
            .card {
                width: 80%;
                /* Más ancho en pantallas de PC */
            }
        }

        /* Ajustes para pantallas pequeñas */
        @media (max-width: 768px) {
            .card {
                width: 90%;
                /* Más estrecho en pantallas pequeñas */
            }
        }

        /* Ajustes para pantallas muy pequeñas */
        @media (max-width: 576px) {
            .card {
                width: 95%;
                /* Más estrecho en pantallas móviles */
            }
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Estilo para el header */
        .header {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #032859;
            /* Azul oscuro para el header */
            color: #fff;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            /* Alineación a la izquierda */
            font-size: 24px;
            z-index: 1000;
        }

        /* Contenido principal */
        .content {
            padding: 20px;
            margin-top: 20px;
            /* Espacio para el header */
        }

        /* Centrar el contenido de inicio de sesión */
        .d-flex-centered {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
        }

        /* Estilos del contenedor del logo */
        .logo-container {
            position: absolute;
            top: 80px;
            /* Ajuste para que el logo no quede tapado por el header */
            left: 10px;
            z-index: 500;
            /* Logo por debajo del header */
        }

        /* Estilos del logo */
        .logo {
            width: 100px;
            height: auto;
            opacity: 1;
            /* Sin opacidad para mayor visibilidad */
        }

        /* Ajustes responsivos */
        @media (max-width: 768px) {
            .header {
                font-size: 18px;
                justify-content: center;
            }

            .logo {
                width: 80px;
                /* Tamaño más pequeño para móviles */
            }

            .content {
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .header {
                font-size: 16px;
            }

            .logo {
                width: 60px;
            }
        }
    </style>
</head>

<body>
    <!-- Header en la parte superior -->
    <div class="header">
        COORDINACIÓN DE INGLÉS
    </div>

    <!-- Contenedor del logo -->
    <div class="logo-container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
    </div>

    <!-- Contenido principal centrado -->
    <div class="content d-flex-centered">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>