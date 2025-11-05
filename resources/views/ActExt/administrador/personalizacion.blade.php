@extends('ActExt.layouts.app')

@section('content')
    <div class="container">
        <h1>
            <center><b>Panel de Personalización de la página principal</b></center>
        </h1>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                    role="tab">Imagenes carrusel</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                    role="tab">Opciones de navegación</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#gifs" type="button"
                    role="tab">Banners de gif</button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Imagenes actuales del carrusel</h4>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCarrusel">Insertar
                            nueva imagen</button>
                    </div>
                </div>
                <div class="row mt-2 justify-content-center">
                    @foreach ($carrusel as $img)
                        @if (basename($img) == 'banner0.png')
                            <div class="card ms-2 me-2 mt-3" style="width: 18rem;">
                                <img src="{{ asset('images/carrusel/' . basename($img)) }}" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <button href="#" class="btn btn-danger" disabled>Eliminar</button>
                                </div>
                            </div>
                        @else
                            <div class="card ms-2 me-2 mt-3" style="width: 18rem;">
                                <img src="{{ asset('images/carrusel/' . basename($img)) }}" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <a href="{{ route('eliminar.imagen.carrusel', ['nombre' => basename($img)]) }}"
                                        onclick="return confirm('¿Estás seguro de eliminar este registro?');"
                                        class="btn btn-danger">Eliminar</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>


            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Opciones actuales de navegación</h4>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalOpciones">Agregar
                            nueva opcion</button>
                    </div>
                    <div class="row mt-2 justify-content-center">
                        @foreach ($opciones as $opc)
                            <div class="card ms-2 me-2 mt-3" style="width: 18rem;">
                                <img src="{{ asset('images/paginaP/opciones/' . $opc->nombreImg) }}" class="card-img-top"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $opc->titulo }}</h5>
                                    <p class="card-text">{{ $opc->descripcion }}</p>

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-id="{{ $opc->id }}"
                                        data-titulo="{{ $opc->titulo }}" data-descripcion="{{ $opc->descripcion }}"
                                        data-vinculo="{{ $opc->vinculo }}">
                                        Editar
                                    </button>


                                    <a href="{{ route('eliminar.opcion', ['id' => $opc->id]) }}"
                                        onclick="return confirm('¿Estás seguro de eliminar este registro?');"
                                        class="btn btn-danger">Eliminar</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row mt-2 justify-content-center">

                </div>
            </div>
            <div class="tab-pane fade" id="gifs" role="tabpanel">
                <div class="row">
                    <div class="col-sm-6">
                        <h4>Opciones actuales de banners de gif</h4>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2">
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalBanner">Agregar
                            nueva opcion</button>
                    </div>
                    <div class="row mt-2 justify-content-center">

                    </div>
                </div>
                <div class="row mt-2 justify-content-center">
                    @php
                        $contador = 0;
                    @endphp
                    @foreach ($banner as $img)
                        <div class="card ms-2 me-2 mt-3" style="width: 18rem;">
                            <img src="{{ asset('images/paginaP/bannersGifs/' . basename($img)) }}" class="card-img-top"
                                alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{$titulos[$contador]}}</h5>
                                <a href="{{ route('eliminar.banner.gif', ['nombre' => basename($img)]) }}"
                                    onclick="return confirm('¿Estás seguro de eliminar este registro?');"
                                    class="btn btn-danger">Eliminar</a>
                            </div>
                        </div>
                        @php
                            $contador ++;
                        @endphp
                        
                    @endforeach
                </div>
            </div>
        </div>

        {{-- MODAL SUBIR IMAGEN --}}
        <div class="modal fade" id="modalCarrusel" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Carga de nueva imagen para el carrusel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Medidas de la imagen <strong>1080 * 300 px</strong> </p>
                        <form action="{{ route('subir.imagen.carrusel') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input class="form-control" type="file" name="imagen" required>
                            <button class="btn btn-success mt-2" type="submit">Subir Imagen</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>
        {{-- SUBIR IMAGEN  --}}

        {{-- MODAL SUBIR OPCION --}}
        <div class="modal fade" id="modalOpciones" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Carga de nueva opción de navegación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Por favor, completa todos los campos.</p>
                        <form action="{{ route('agregar.opcion') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="">Titulo de la opcion</label>
                            <input type="text" class="form-control" name="titulo" required>

                            <label for="">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" required>

                            <label for="">Vinculo de redirección</label>
                            <input type="text" class="form-control" name="vinculo" required>

                            <input class="form-control mt-3" type="file" name="imagen" required>
                            <button class="btn btn-success mt-2" type="submit">Agregar opción</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>
        {{-- SUBIR OPCION  --}}

        {{-- MODAL EDITAR OPCION --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" action="" method="POST">
                            @csrf

                            <input type="hidden" id="registro_id" name="id">

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="titulo" name="nombre">
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">vinculo</label>
                                <input type="text" class="form-control" id="vinculo" name="vinculo">
                            </div>

                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        {{-- MODAL OPCION --}}

        {{-- MODAL SUBIR BANNER --}}
        <div class="modal fade" id="modalBanner" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Carga de nuevo banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Medidas del banner <strong>1080 * 400 px</strong> </p>
                        <form action="{{ route('subir.banner.gif') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <label for="">Titulo del banner (<strong>SE MOSTRARA EN LA PAGINA PRINCIPAL</strong>)</label>
                            <input class="form-control" type="text" name="titulo" required>
                            <label class="mt-2" for="">Selecciona la imagen tipo GIF para el banner</label>
                            <input class="form-control " type="file" name="imagen" required>
                            <button class="btn btn-success mt-2" type="submit">Subir Banner</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>
        {{-- MODAL SUBIR BANNER --}}

        @push('js')
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var editModal = document.getElementById("editModal");

                    editModal.addEventListener("show.bs.modal", function(event) {
                        var button = event.relatedTarget; // Botón que abre el modal

                        var id = button.getAttribute("data-id");
                        var titulo = button.getAttribute("data-titulo");
                        var descripcion = button.getAttribute("data-descripcion");
                        var vinculo = button.getAttribute("data-vinculo");

                        // Asignar valores a los campos del modal
                        document.getElementById("registro_id").value = id;
                        document.getElementById("titulo").value = titulo;
                        document.getElementById("descripcion").value = descripcion;
                        document.getElementById("vinculo").value = vinculo;

                        // Construir la URL correcta y asignarla al formulario
                        document.getElementById("editForm").action = "{{ url('editar-opcion') }}/" + id;
                    });
                });
            </script>
        @endpush

        @if (session('success'))
            <meta name="toast-success" content="{{ session('success') }}">
        @endif
        @if (session('danger'))
            <meta name="toast-error" content="{{ session('danger') }}">
        @endif
    </div>
@endsection
