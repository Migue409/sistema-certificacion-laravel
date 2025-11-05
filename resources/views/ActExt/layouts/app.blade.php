<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="Sat, 01 Jan 2000 00:00:00 GMT" />
    <title>Panel de Administración</title>
    <link rel="shortcut icon" href="{{ asset('images/logoCoordinacion.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
    <style>
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
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-title {
            font-size: 30px;
        }

        .hamburger {
            font-size: 24px;
            cursor: pointer;
            color: #fff;
            /* Color blanco para el icono de hamburguesa */
        }

        /* Estilo para la barra lateral */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            height: 100%;
            width: 250px;
            background-color: #e0e0e0;
            /* Color gris claro */
            color: #fff;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            transition: left 0.3s ease;
            z-index: 1050;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar .nav-link {
            color: #333;
            /* Color de los enlaces en gris oscuro */
            padding: 10px 10px;
            /* Más espacio interno para centrar el texto */
            border-radius: 20px;
            /* Redondeado más sutil */
            margin: 10px 15px;
            /* Espaciado horizontal y vertical */
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
            /* Transición suave para color */
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            /* Espacio entre icono y texto */
        }

        .sidebar .nav-link:hover {
            background-color: #032859;
            /* Azul oscuro al pasar el ratón */
            color: #fff;
        }

        .sidebar .navbar-brand {
            font-size: 24px;
            color: #032859;
            /* Azul oscuro para el título */
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .logout-button {
            background: none;
            border: none;
            color: #333;
            padding: 10px 10px;
            border-radius: 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        .logout-button:hover {
            background-color: #032859;
            /* Azul oscuro */
            color: #fff;
            /* Cambia el color del texto */
        }


        /* Contenido principal */
        .content {
            padding: 20px;
            margin-top: 60px;
            /* Espacio para el header */
        }

        /* Overlay para cerrar la barra */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }

        .overlay.active {
            display: block;
        }

        /* Estilos del contenedor del logo */
        .logo-container {
            position: absolute;
            top: 70px;
            /* Ajusta este valor para situarlo justo debajo del header */
            left: 20px;
            /* Ajuste desde el borde izquierdo */
            z-index: 1050;
            /* Para que el logo quede sobre otros elementos */
        }

        /* Estilos del logo */
        .logo {
            width: 150px;
            /* Ajusta el tamaño del logo */
            height: auto;
            opacity: 0.5;
            /* Ajusta la transparencia del logo */
        }
    </style>
</head>

<body>
    <!-- Header con el icono de menú -->
    <div class="header">
        <span class="hamburger" onclick="toggleSidebar()">&#9776;</span>
        <h1 class="header-title">COORDINACIÓN DE INGLÉS</h1>
    </div>

    <!-- Contenedor del logo -->
    <div class="logo-container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
    </div>

    <!-- Barra lateral -->
    <nav class="sidebar" id="sidebar">
        <a class="navbar-brand" href="#">Administrador</a>
        <ul class="navbar-nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.index') }}">
                    <i class="fas fa-calendar-alt"></i> Actividades
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('estudiantes.info') }}">
                    <i class="fas fa-user-graduate"></i> Buscar Estudiantes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('registros.teamTask') }}">
                    <i class="fa-solid fa-graduation-cap"></i> TeamTask
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('registros.recurseEC') }}">
                    <i class="fa-solid fa-school"></i> Recurse Educación Continua
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('profesores.index') }}">
                    <i class="fas fa-chalkboard-teacher"></i> Profesores
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.personalizacion') }}">
                    <i class="fa-solid fa-pen-to-square"></i> Personalización de página principal
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.certificacion.ingles') }}">
                    <i class="fa-solid fa-award"></i> Certificación de Inglés
                </a>
            </li>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="nav-link logout-button">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </button>
            </form>
        </ul>
    </nav>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Contenido principal -->
    <div class="content">
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    @stack('js')
</body>
<footer class="footer">
    <strong> <a href="{{route('admin.tutoriales')}}">Tutoriales</a>.</strong>
    <a href="mailto:adairvazquezcr@gmail.com"> <i class="fa-solid fa-question"></i> Dudas o comentarios.</a>
</footer>

</html>
