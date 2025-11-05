@extends('ActExt.layouts.app') <!-- Extiende el layout base -->

@section('title', 'Panel de Administración') <!-- Título de la página -->

@section('content')
    @php use Illuminate\Support\Facades\File; @endphp

    <div class="container">
        <h1>
            <center><b>Tutoriales del sistema</b></center>
        </h1>

        <div class="row">
            @php
                $videoFiles = File::files(public_path('videos'));
            @endphp

            @foreach ($videoFiles as $video)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoModal"
                                data-video="{{ asset('videos/' . $video->getFilename()) }}">
                                Ver {{ $video->getFilename() }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach



        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reproduciendo Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center">
                    <video id="modalVideoPlayer" width="100%" controls>
                        <source src="" type="video/mp4">
                        Tu navegador no soporta el video.
                    </video>
                </div>
            </div>
        </div>
    </div>

    <script>
        const videoModal = document.getElementById('videoModal');
        const videoPlayer = document.getElementById('modalVideoPlayer');

        videoModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const videoSrc = button.getAttribute('data-video');
            videoPlayer.querySelector('source').src = videoSrc;
            videoPlayer.load();
        });

        videoModal.addEventListener('hidden.bs.modal', function() {
            videoPlayer.pause();
            videoPlayer.currentTime = 0;
        });
    </script>

@endsection
