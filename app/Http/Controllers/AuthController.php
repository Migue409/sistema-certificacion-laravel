<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Constructor (sin middleware para caché)
    public function __construct()
    {
        // No es necesario middleware de caché aquí
    }

    // Procesar el login
    public function login(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'matricula' => 'required|string',
            'curp' => 'required|string|min:4|max:4',
        ]);

        // Log los valores recibidos para depuración
        Log::info('Login Intento', [
            'matricula' => $request->matricula,
            'curp' => $request->curp
        ]);
 
        // Lógica de autenticación
        $usuario = Usuario::where('matricula', $request->matricula)
            ->where('curp', 'like', $request->curp . '%') // Coincide con los primeros 4 caracteres del CURP
            ->whereIn('id_rol', [1, 2, 3]) // Acepta roles 1 (administrador) y 2 (estudiante)
            ->first();

        if ($usuario) {
            Auth::login($usuario); // Iniciar sesión con el usuario encontrado
            Log::info('Usuario autenticado', ['usuario' => $usuario]);

            // Redirigir según el rol
            if ($usuario->id_rol == 1) {
                return redirect()->route('admin.dashboard'); // Redirige al dashboard del administrador
            } elseif ($usuario->id_rol == 2) {
                return redirect()->route('estudiantes.index'); // Redirige a la página de estudiantes
            }elseif($usuario->id_rol == 3){
                return redirect()->route('prof.vista');
            }
        } else {
            Log::warning('Intento de login fallido', [
                'matricula' => $request->matricula,
                'curp' => $request->curp
            ]);
            return back()->with('error', 'Credenciales inválidas.');
        }
    }

    // Mostrar formulario de login
    public function showLoginForm()
    {
        if (Auth::check()) {
            // Redirigir a la página correspondiente si ya está autenticado
            $usuario = Auth::user();
            if ($usuario->id_rol == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($usuario->id_rol == 2) {
                return redirect()->route('estudiantes.index');
            }elseif($usuario->id_rol == 3){
                return redirect()->route('profesor.index');
            }
        }

        return view('ActExt.login');
    }

    // Procesar logout
    public function logout(Request $request)
    {
        Auth::logout();  // Cerrar sesión
        $request->session()->invalidate();  // Invalidar sesión
        $request->session()->regenerateToken();  // Regenerar token CSRF

        // Redirigir a la página de login con encabezados para evitar caché
        return redirect()->route('login')->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT'
        ]);
    }
}