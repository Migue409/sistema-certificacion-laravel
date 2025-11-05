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

    <title>Pre registro Team Task Language</title>

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

                <h1 class="mt-5">Pre registro Team Task Language</h1>

            </div>

        </div><br>

        <h5 style="color:white; background-color: #ff5900; display: inline-block; padding: 2px 5px; border-radius: 5px"
            class="mt-3">COMPLETA TODOS LOS DATOS Y VERIFICA QUE SEAN CORRECTOS.</h5>

        <form action="{{ route('registro.teamTask') }}" method="POST">

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

                </div>

                <!-- Columna Derecha -->

                <div class="col-md-6">

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

                    <div class="mb-3">

                        <label for="correo" class="form-label">

                            Ingresa tu correo electrónico Institucional.

                        </label>

                        <input type="email" class="form-control" id="correo" name="correo"
                            pattern="^[a-zA-Z0-9._%+-]+@e\.uttecamac\.edu\.mx$"
                            title="Debe ser un correo con la terminación @e.uttecamac.edu.mx" required />

                    </div>

                    <div class="mb-3">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        Los requisitos del proyecto son:
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body" style="color: black">
                                        Los requisitos del proyecto son: <br><br>

                                        - Interés en el tema a tratar. <br>
                                        - Disponibilidad de tiempo de aproximadamente 4 horas semanales en el periodo
                                        comprendido.<br>

                                        - Nivel de inglés B1 o superior (el programa requiere leer, escribir y evaluar
                                        en el idioma inglés)<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label for="" class=" mt-2 form-label">
                            ¿Cumples con los requisitos?
                        </label>
                        <select class="form-select" name="requisitos" aria-label="Default select example" required>
                            <option style="color: black !important" selected>Selecciona...</option>
                            <option style="color: black !important" value="Sí, cumplo con los requisitos">Sí, cumplo
                                con los requisitos</option>
                            <option style="color: black !important"
                                value="No, se me complica la disponibilidad de tiempo">No, se me complica la
                                disponibilidad de tiempo</option>
                            <option style="color: black !important" value="No, el nivel de inglés es un problema">No,
                                el nivel de inglés es un problema</option>
                        </select>
                    </div>

                    <div class="mb-3">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Los beneficios de la participación en Team Task Language son:
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body" style="color: black">
                                    ✅ Constancia de participación con valor curricular <br> ✅ Historial de participación
                                    en proyectos InduTwin para movilidad internacional <br> ✅ Apoyo en una asignatura de
                                    tu programa educativo (adquisición constancia) <br> ✅ Desarrollo de habilidades
                                    comunicativas y sociales <br> ✅ Desarrollo de habilidades blandas <br> ✅ Adquisición
                                    de conocimiento técnico específico"
                                </div>
                            </div>
                        </div>

                        <div id="escondido"></div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" required value="no"
                                id="flexCheckDefault">
                            <label
                                onclick="document.getElementById('escondido').innerHTML = `<input type='hidden' name='check' value='ok'>`"
                                class="form-check-label" for="flexCheckDefault">
                                Estoy enterado e interesado en recibir los beneficios del curso
                            </label>
                        </div>
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
                        La Universidad Tecnológica de Tecámac (UTTEC) se interesa en proteger la confidencialidad y
                        privacidad de la información que se le ha confiado. Como parte de esta obligación fundamental,
                        UTTEC se compromete a proteger y utilizar adecuadamente datos personales y de contacto que se
                        recopilen a través de este formulario y/o sea proporcionada voluntariamente por los interesados
                        en participar en el curso de Team Task Language.
                        La intención de este formulario es recopilar datos personales y de contacto que son
                        proporcionados voluntariamente por los interesados, para que podamos iniciar y dar seguimiento a
                        su proceso de registro al curso de Team Task Language.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">He leído y estoy de
                            acuerdo en el uso de datos para los fines de Team Task Language</button>
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
