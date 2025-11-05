<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Opcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Personalizacion extends Controller
{
    public function agregarOpcion(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
            'vinculo' => 'required|url',
            'imagen' => 'required|image|max:2048'
        ]);

        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Obtener el archivo
        $imagen = $request->file('imagen');

        // Definir la ruta donde se guardará la imagen
        $rutaDestino = public_path('images/paginaP/opciones');

        // Asegurarse de que la carpeta existe
        if (!File::exists($rutaDestino)) {
            File::makeDirectory($rutaDestino, 0777, true, true);
        }

        // Generar un nombre único para la imagen
        $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

        // Mover la imagen a la carpeta
        $imagen->move($rutaDestino, $nombreImagen);


        Opcion::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'nombreImg' => $nombreImagen,
            'vinculo' => $request->vinculo
        ]);

        return back()->with('success', '¡Opción agregada con exito!');
    }



    public function editarOpcion(Request $req, $id)
    {
        try {
            // Encontrar el registro por su ID
            $registro = Opcion::findOrFail($req->id);

            // Actualizar los campos con los datos recibidos
            $registro->update([
                'titulo' => $req->input('nombre'),
                'descripcion' => $req->input('descripcion'),
                'vinculo' => $req->input('vinculo')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }

        return back()->with('success', '¡Opción editada con exito!');
    }


    public function cargarImagenes()
    {
        $carrusel = File::files(public_path('images/carrusel'));
        $imagenes = File::files(public_path('images/paginaP'));
        $banner = File::files(public_path('images/paginaP/bannersGifs'));
        $titulos = Banner::pluck('titulo');
        
        $opciones = Opcion::all();


        return view('ActExt.administrador.personalizacion', compact('carrusel', 'imagenes', 'opciones','banner', 'titulos'));
    }

    public function eliminarOpcion($id)
    {
        $registro = Opcion::findOrFail($id);

        // Eliminar el registro
        $registro->delete();

        return back()->with('success', '¡Opción eliminada con exito!');
    }

    public function subirImagenCarrusel(Request $request)
    {
        // Validar que el archivo sea una imagen
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Obtener el archivo
        $imagen = $request->file('imagen');

        // Definir la ruta donde se guardará la imagen
        $rutaDestino = public_path('images/carrusel');

        // Asegurarse de que la carpeta existe
        if (!File::exists($rutaDestino)) {
            File::makeDirectory($rutaDestino, 0777, true, true);
        }

        // Generar un nombre único para la imagen
        $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

        // Mover la imagen a la carpeta
        $imagen->move($rutaDestino, $nombreImagen);

        return back()->with('success', 'Imagen subida correctamente');
    }

    public function subirImagenGif(Request $request)
    {
        
        // Obtener el archivo
        $imagen = $request->file('imagen');
    
        // Definir la ruta donde se guardará la imagen
        $rutaDestino = public_path('images/paginaP/bannersGifs');

        // Asegurarse de que la carpeta existe
        if (!File::exists($rutaDestino)) {
            File::makeDirectory($rutaDestino, 0777, true, true);
        }

        // Generar un nombre único para la imagen
        $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

        // Mover la imagen a la carpeta
        $imagen->move($rutaDestino, $nombreImagen);

        Banner::create([
            'titulo' => $request->titulo,
            'nombreImg' => $nombreImagen
        ]);

        return back()->with('success', 'Banner subido correctamente');
    }

    function eliminarImagenCarrusel($nombreArchivo)
    {
        $ruta = public_path("images/carrusel/{$nombreArchivo}");

        if (File::exists($ruta)) {
            File::delete($ruta);
            return back()->with('danger', 'Imagen eliminada correctamente');
        } else {
            return "La imagen no existe.";
        }
    }

    public function eliminarBannerGif($nombreArchivo){
        $ruta = public_path("images/paginaP/bannersGifs/{$nombreArchivo}");

        if (File::exists($ruta)) {
            File::delete($ruta);
            Banner::where('nombreImg', $nombreArchivo)->delete();
            return back()->with('danger', 'Imagen eliminada correctamente');
        } else {
            return "La imagen no existe.";
        }


    }
}
