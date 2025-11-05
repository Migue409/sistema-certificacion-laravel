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
    <title>Registro</title>
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
            <div class="col-md-7">
                <h1 class="mt-5">Registro de estudiante</h1>
            </div>
        </div><br>
        <h5 style="color:white; background-color: #ff5900; display: inline-block; padding: 2px 5px; border-radius: 5px"
            class="mt-3">COMPLETA TODOS LOS DATOS Y VERIFICA QUE SEAN CORRECTOS.</h5>
        <form action="{{ route('registro.estudiante') }}" method="POST">
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
                        <label for="nombre" class="form-label">Nombre completo.</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            oninput="this.value = this.value.toUpperCase()" aria-describedby="nombreDesc" required />
                        <div id="nombreDesc" style="color: white !important;" class="form-text">
                            Nombre completo comenzando por nombre(s).
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="curp" class="form-label">CURP</label>
                        <input type="text" class="form-control" id="curp" name="curp"
                            aria-describedby="curpDesc" oninput="this.value = this.value.slice(0, 18)" required />
                        <div id="curpDesc" style="color: white !important;" class="form-text">18 dígitos.</div>
                    </div>
                    <div class="mb-3">
                        <label for="nivel" class="form-label">Nivel de inglés</label>
                        <select class="form-select" aria-label="Default select example" name="nivel" id="idNivel"
                            required>
                            <option style="color: black !important" disabled selected value="">Selecciona</option>
                            <option style="color: black !important" value="Elementary">Elementary</option>
                            <option style="color: black !important" value="Pre-intermediate">Pre-intermediate</option>
                        </select>
                    </div>
                </div>
                <!-- Columna Derecha -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="recurse" class="form-label">
                            ¿Eres estudiante en situación de recurse de <strong>solo inglés</strong>?
                        </label>
                        <select class="form-select" aria-label="Default select example" name="recurse" id="recurse"
                            required>
                            <option style="color: black !important" disabled selected value="">Selecciona</option>
                            <option style="color: black !important" value="si">Sí</option>
                            <option style="color: black !important" value="no">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="divi" class="form-label">Selecciona la división a la que perteneces.</label>
                        <select class="form-select" aria-label="Default select example" name="divi" id="divi"
                            required>
                            <option style="color: black !important" disabled selected value="">Selecciona</option>
                            <option style="color: black !important" value="DEA">DEA</option>
                            <option style="color: black !important" value="DEI">DEI</option>
                            <option style="color: black !important" value="DPI">DPI</option>
                            <option style="color: black !important" value="DQB">DQB</option>
                            <option style="color: black !important" value="DTIC">DTIC</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="grupoDiv" class="form-label">
                            Ingresa el grupo de <strong>TU DIVISIÓN</strong> al que perteneces.
                        </label>
                        <input type="text" class="form-control" name="grupoDiv" id="grupoDiv" required />
                    </div>
                    <div class="mb-3">
                        <label for="grupoIng" class="form-label">
                            Ingresa el grupo de <strong>INGLÉS</strong> al que perteneces.
                        </label>
                        <input type="text" class="form-control" name="grupoIng" id="grupoIng" required />
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">
                            Ingresa tu correo electrónico Institucional.
                        </label>
                        <input type="email" class="form-control" id="correo" name="correo"
                            pattern="^[a-zA-Z0-9._%+-]+@e\.uttecamac\.edu\.mx$"
                            title="Debe ser un correo con la terminación @e.uttecamac.edu.mx" required />
                    </div>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" value="Enviar" class="btn btn-lg btn-success mt-3" /><br><br>
                <a style="color: white !important;" class="mt-2" href="{{ route('login.form') }}">¿Ya estas
                    registrado? Inicia sesión.</a>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-cpl6L9i8gUpf/+QmbZ3cxTh/1N9uRkR86sU6X2V8a7K8YlT9Yu9JObQ9fZ1CZg5n" crossorigin="anonymous">
    </script>
</body>

</html>
