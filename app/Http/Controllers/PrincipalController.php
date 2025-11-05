<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Opcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PrincipalController extends Controller
{
    public function PaginaPrincipal()
    {

        $imagenes = File::files(public_path('images/carrusel'));
        $banner = File::files(public_path('images/paginaP/bannersGifs'));

        // Ordenar las imágenes colocando "banner0.png" primero
        usort($imagenes, function ($a, $b) {
            return basename($a) === 'banner0.png' ? -1 : (basename($b) === 'banner0.png' ? 1 : 0);
        });

        $totalImagenes = count($imagenes);
        $titulosBanner = Banner::select('id', 'titulo')->get();
        $banners = Banner::select('id', 'nombreImg')->get();;

        $opciones = Opcion::all();

        return view('Principal.index', compact('totalImagenes', 'opciones', 'imagenes', 'titulosBanner', 'banners'));
    }
}
