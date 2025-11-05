<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />

    <link rel="shortcut icon" href="{{ asset('images/logoCoordinacion.png') }}" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="{{ asset('js/alerts.js') }}"></script>

    <title>Modalidad de recurse en Educación Continua</title>

    <style>
        .logo {

            width: 30%;

            min-height: 10vh;

            box-sizing: border-box;

            border-radius: 50%;

        }



        * {

            color: white;

        }



        body {

            background-image: url("{{ asset('images/fondoFormulario.png') }}");



            background-position: center;

            background-repeat: repeat;

        }



        .fondoCarta {

            background-color: cornflowerblue;

            width: 90%;

            min-height: 80vh;

            padding: 1rem;

            box-sizing: border-box;

            border-radius: 30px;

            box-shadow: 10px 10px 10px 10px rgba(0, 0, 0, 0.3);

        }
    </style>

</head>



<body>

    <main class="container fondoCarta mt-2 mb-5">

        <div class="row">

            <div class="col-md-4">

                <img src="{{ asset('images/logoCoordinacion.png') }}" class="logo ms-3 mt-3" alt="Logo" />

            </div>

            <div class="col-md-8">

                <h1 class="mt-5">Modalidad de recurse en Educación Continua</h1>

            </div>

        </div><br>

        <h5 style="color:white; background-color: #ff5900; display: inline-block; padding: 2px 5px; border-radius: 5px"
            class="mt-3">COMPLETA TODOS LOS DATOS Y VERIFICA QUE SEAN CORRECTOS.</h5>

        <form action="{{ route('registro.recurseEC') }}" method="POST">

            @csrf

            <div class="row">

                <!-- Columna Izquierda -->

                <div class="col-md-6">

                    <div class="mb-3">
                        <label for="matricula" class="form-label">Matrícula.</label>

                        <input type="number" class="form-control" id="matricula" name="matricula"
                            aria-describedby="matriculaDesc" oninput="this.value = this.value.slice(0, 10)" required />

                        <div id="matriculaDesc" style="color: white !important;" class="form-text">Deben ser 10 números.

                        </div>
                    </div>

                    <div class="mb-3">

                        <label for="nombre" class="form-label">Nombre(s).</label>

                        <input type="text" class="form-control" id="nombre" name="nombre"
                            oninput="this.value = this.value.toUpperCase()" aria-describedby="nombreDesc" required />

                    </div>

                    <div class="mb-3">

                        <label for="nombre" class="form-label">Apellido Paterno.</label>

                        <input type="text" class="form-control" id="app" name="app"
                            oninput="this.value = this.value.toUpperCase()" aria-describedby="nombreDesc" required />

                    </div>

                    <div class="mb-3">

                        <label for="nombre" class="form-label">Apellido Materno.</label>

                        <input type="text" class="form-control" id="apm" name="apm"
                            oninput="this.value = this.value.toUpperCase()" aria-describedby="nombreDesc" required />

                    </div>

                    <div class="mb-3">

                        <label for="curp" class="form-label">Teléfono (WhatsApp)</label>

                        <input type="tel" class="form-control" id="tel" name="tel"
                            aria-describedby="curpDesc" oninput="this.value = this.value.slice(0, 10)" required />

                        <div id="curpDesc" style="color: white !important;" class="form-text">10 dígitos.</div>

                    </div>

                    <div class="mb-3">

                        <label for="divi" class="form-label">Selecciona la división a la que perteneces.</label>

                        <select class="form-select" aria-label="Default select example" name="divi" id="divi"
                            required>

                            <option style="color: black !important" disabled selected value="">Selecciona
                            </option>

                            <option style="color: black !important" value="DEA">DEA</option>

                            <option style="color: black !important" value="DEI">DEI</option>

                            <option style="color: black !important" value="DPI">DPI</option>

                            <option style="color: black !important" value="DQB">DQB</option>

                            <option style="color: black !important" value="DTIC">DTIC</option>

                        </select>

                    </div>
                </div>

                <!-- Columna Derecha -->

                <div class="col-md-6">



                    <div class="mb-3">

                        <label for="correo" class="form-label">

                            Ingresa tu correo electrónico Institucional.

                        </label>

                        <input type="email" class="form-control" id="correo" name="correo"
                            pattern="^[a-zA-Z0-9._%+-]+@e\.uttecamac\.edu\.mx$"
                            title="Debe ser un correo con la terminación @e.uttecamac.edu.mx" required />

                    </div>

                    <div class="mb-3">

                        <label for="correo" class="form-label">
                            Ingresa tu Grupo de tu Division.
                        </label>

                        <input oninput="this.value = this.value.toUpperCase()" class="form-control" type="text" name="GrupoDivi" required id="">
                    </div>

                    <div class="mb-3">

                        <label for="correo" class="form-label">
                            Ingresa tu Grupo de Inglés regular.
                        </label>

                        <input oninput="this.value = this.value.toUpperCase()" class="form-control" type="text" name="GrupoIngReg" required id="">
                    </div>


                    <div class="mb-3">

                        <label for="recurse" class="form-label">Elige la asignatura de inglés de recurse.</label>

                        <select class="form-select" aria-label="Default select example" name="recurse"
                            id="recurse" required>

                            <option style="color: black !important" disabled selected value="">Selecciona
                            </option>

                            <option style="color: black !important" value="INGLES I">Inglés I</option>

                            <option style="color: black !important" value="INGLES II">Inglés II</option>

                            <option style="color: black !important" value="INGLES III">Inglés III</option>

                            <option style="color: black !important" value="INGLES IV">Inglés IV</option>

                            <option style="color: black !important" value="INGLES V">Inglés V</option>

                            <option style="color: black !important" value="INGLES VI">Inglés VI</option>

                            <option style="color: black !important" value="INGLES VII">Inglés VII</option>

                            <option style="color: black !important" value="INGLES VIII">Inglés VIII</option>

                            <option style="color: black !important" value="INGLES XI">Inglés XI</option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label for="nivel" class="form-label">Elige Elige el nivel de inglés de recurse.</label>

                        <select class="form-select" aria-label="Default select example" name="nivel"
                            id="nivel" required>

                            <option style="color: black !important" disabled selected value="">Selecciona
                            </option>

                            <option style="color: black !important" value="ELEMENTARY">Elementary</option>

                            <option style="color: black !important" value="PRE-INTERMEDIATE">Pre-intermediate</option>

                            <option style="color: black !important" value="INTERMEDIATE">Intermediate</option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="text-center">

                <input type="submit" value="Enviar" class="btn btn-lg btn-success mt-3" /><br><br>
            </div>

        </form>

        {{-- MODAL --}}
        <div class="modal fade" id="myModal" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle" style="color:black">Bienvenido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body" style="color:black; text-align: justify;">
                        La Universidad Tecnológica de Tecámac (UTTEC), a través de la Coordinación de Inglés (CI), se
                        dedica a proteger la confidencialidad y privacidad de la información que se le ha confiado.
                        <br><br>
                        Como parte de este compromiso; la CI resguardará y utilizará la información personal que se
                        recopile a través de este formulario con fines de seguimiento a la modalidad del recurse de las
                        asignaturas de inglés en Educación Continua.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Acepto el uso de los
                            datos para los fines mencionados</button>
                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <meta name="toast-success" content="{{ session('success') }}">
        @endif
        @if (session('error'))
            <meta name="toast-error" content="{{ session('error') }}">
        @endif

    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })

        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('myModal'));
            myModal.show();
        });
    </script>
</body>



</html>
