<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"

        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"

        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">

    </script>

    <link rel="shortcut icon" href="{{ asset('images/logoCoordinacion.png') }}" type="image/x-icon">

    <title>Inicio | Coordinacion de ingles</title>

    <style>

        .logo {

            width: 15vh;

            border-radius: 50px;

        }



        body {

            background-image: url("{{ asset('images/fondoFormulario.png') }}");



            background-position: center;

            background-repeat: repeat;

        }



        .nav-tabs .nav-link.active {

            /* Naranja */

            color: black !important;

        }



        .icono {

            width: 24px; /* Igual que un icono de Font Awesome */

            height: 24px;

            border-radius: 50%

        }

    </style>

</head>



<body>



    <main class="container mt-1 rounded-3" style="background-color:#6495ED; border">

        <br>

        <div class="row">

            <div class="col-md-1">

                <img class="logo" src="{{ asset('images/logoCoordinacion.png') }}" alt="" srcset="">

            </div>

            <div class="col-md-8">

                <h1 class="mt-3 ms-3" style="display: inline-block; color: white;">Coordinación de inglés</h1>



            </div>



            <hr class="mt-3" style="border: 2px solid rgb(0,32,96); width: 100%;">

            {{-- INICIO DE CARRUSEL --}}

            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

                <div class="carousel-indicators">

                    @for ($i = 0; $i < $totalImagenes; $i++)

                        <button type="button" data-bs-target="#carouselExampleIndicators"

                            data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}"

                            aria-label="Slide {{ $i + 1 }}"></button>

                    @endfor

                </div>

                {{-- CARGA DE IMAGENES EN LA CARPETA (NECESARIO QUE SE LLAMEN "banner+numero_consecuente.png" EJEMPLO "banner3.png") --}}

                <div class="carousel-inner">

                    @foreach ($imagenes as $index => $imagen)

                        @php
                            
                            // SI SE NECESITA CAMBIAR ESTO RECOMIENDO QUE SE AGREGE UNA TABLA MAS A LA BD
                            // LLAMADA "CARRUSEL" EN ESTA SOLO SE GUARDA EL LINK DE REDIRECCIONAMIENTO Y EL NOMBRE
                            // DE LA IMAGEN, ESTE SE GENERA AUTOMATICAMENTE CUANDO SE AGREGA LA IMAGEN

                            $nombre = basename($imagen);

                            if ($nombre == 'banner2.png') {

                                $ruta =

                                    'https://drive.google.com/drive/folders/1bAkLUHt6GVKvkw-8vbx5M644Tb8tt-RB';

                            } elseif ($nombre == 'banner3.png') {

                                $ruta = 'https://drive.google.com/drive/folders/1eG-YU02M_wgVzsDvA5B04Ru1WGUfDFOE';

                            } elseif ($nombre == 'banner4.png') {

                                $ruta =

                                    'https://docs.google.com/forms/d/e/1FAIpQLSdNzoRqhqvkG-8OjZ4LwtikY0u92gfrRRRivVhRi7sdYdft6A/viewform';

                            } elseif ($nombre == 'banner5.png') {

                                $ruta =

                                    'https://flowcode.com/p/yvAZ9h7lT';

                            } elseif ($nombre == 'banner6.png') {

                                $ruta =

                                    'https://flowcode.com/p/UoNPhVDkJ';

                            } elseif ($nombre == 'banner7.png') {

                                $ruta =

                                    'https://flowcode.com/p/Z7I1YXaCx';

                            } else {

                                $ruta = '';

                            }

                        @endphp



                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">

                            <a href="{{ $ruta }}"><img src="{{ asset('images/carrusel/' . basename($imagen)) }}"

                                    class="d-block w-100" alt="..."></a>

                        </div>

                    @endforeach

                </div>

                {{-- FIN DE CARGA DE LAS IMAGENES --}}



                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"

                    data-bs-slide="prev">

                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>

                    <span class="visually-hidden">Previous</span>

                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"

                    data-bs-slide="next">

                    <span class="carousel-control-next-icon" aria-hidden="true"></span>

                    <span class="visually-hidden">Next</span>

                </button>

            </div>

        </div>

        {{--  FIN CARRUSEL --}}









        <hr style="border: 2px solid rgb(0,32,96); width: 100%;">

        <br>





        @php $primero = true; @endphp



        <ul class="nav nav-tabs text-white" id="myTab" role="tablist">

            @foreach ($titulosBanner as $titulo)

                <li class="nav-item" role="presentation">

                    <button style="font-family: sans-serif; " class="nav-link text-white {{ $primero ? 'active' : '' }}" id="tab-{{ $titulo->id }}"

                        data-bs-toggle="tab" data-bs-target="#pane-{{ $titulo->id }}" type="button" role="tab">

                       <strong>{{ $titulo->titulo }}</strong> 

                    </button>

                </li>

                @php $primero = false; @endphp

            @endforeach

        </ul>



        <div class="tab-content" id="myTabContent">

            @php $primero = true; @endphp

            @foreach ($banners as $img)

                <div class="tab-pane fade {{ $primero ? 'show active' : '' }}" id="pane-{{ $img->id }}"

                    role="tabpanel">

                    <center>

                        <img src="{{ asset('images/paginaP/bannersGifs/' . $img->nombreImg) }}" alt=""

                            height="10%" width="100%">

                    </center>

                </div>

                @php $primero = false; @endphp

            @endforeach

        </div>









        <br>



        {{-- CARTAS DE HIPERVINCULOS --}}

        <hr style="border: 2px solid rgb(0,32,96); width: 100%;">



        @foreach ($opciones as $opc)

            <div class="row ms-2 me-2 mt-2" style="background-color: white; border-radius:20px;">

                <div class="col-md-4">

                    <img class="ms-2 mt-3" src="{{ asset('images/paginaP/opciones/' . $opc->nombreImg) }}"

                        alt="" style="width: 90%">

                </div>

                <div class="col-md-8">

                    <div class="mt-4 mb-2 ms-5 me-1">

                        <h1>{{ $opc->titulo }}</h1><br>

                        <h5>{{ $opc->descripcion }}</h5><br>

                        <a href="{{ $opc->vinculo }}" class="btn btn-success btn-lg mb-2">¡Vamos!</a>

                    </div>

                </div>

            </div>

        @endforeach



        <br>

    </main>

</body>

<footer class="bg-dark text-white mt-2 pt-4 pb-2">

    <div class="container">

        <div class="row">

            <!-- Columna 1: Logo y descripción -->

            <div class="col-md-4">

                <h5 class="text-uppercase">Coordinación de inglés.</h5>

                <p class="small">Encuentranos en el aula ZB-01.</p>

            </div>



            <!-- Columna 2: Enlaces rápidos -->

            <div class="col-md-4">

                <h5 class="text-uppercase">Enlaces</h5>

                <ul class="list-unstyled">

                    <li><a href="{{route('index')}}" class="text-white text-decoration-none">Inicio</a></li>
                    <li><a href="mailto:adairvazquezcr@gmail.com" class="text-white text-decoration-none">Soporte Técnico</a></li>


                </ul>

            </div>



            <!-- Columna 3: Redes sociales -->

            

        </div>



        <!-- Línea divisoria -->

        <hr class="my-3">



        <!-- Derechos de autor -->

        <div class="text-center">

            <p class="mb-0"><img src="{{asset('images/logoCoordinacion.png')}}" class="icono"> Coordinación de inglés.</p>

        </div>

    </div>

</footer>



</html>

