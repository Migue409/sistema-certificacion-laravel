<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ConcentradoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\DatosAcademicosController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstudiantesController; 
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Personalizacion;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\RecurseECController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\TeamTaskController;
use App\Models\RecurseEC;
use App\Models\TeamTask;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CertificacionController;
use App\Http\Controllers\CertificacionEstudianteController;


Route::prefix('api')->group(function () {
    require base_path('routes/api.php');
});

Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/', [PrincipalController::class, 'PaginaPrincipal'])->name('index');

Route::get('/correo', function () {
    return view('ActExt.mails.AsignacionActividadProfesor');
});

Route::get('/mensajesprueba', [ActividadController::class, 'enviarmensaje']); //Ruta que verfica las horas disponibles



//Usuarios
Route::resource('usuarios', ProfesorController::class); //Profesores

// Rutas para profesores
Route::resource('profesores', ProfesorController::class);

Route::delete('profesores/eliminar/{id}', [ProfesorController::class,'destroy'])->name('eliminar.profe');

//Actividades
Route::resource('actividades', ActividadController::class);

Route::get('/api/hours/{fecha}', [ActividadController::class, 'getAvailableHours'])->middleware('auth'); //Ruta que verfica las horas disponibles




//Concentrado Excel
Route::view('/concentrado', 'administrador.concentrado')->name('concentrado')->middleware('auth');
Route::get('/download', [ConcentradoController::class, 'download'])->name('download')->middleware('auth');
Route::post('/concentrado/upload', [ConcentradoController::class, 'upload'])->name('concentrado.upload')->middleware('auth');// Ruta para manejar la carga del archivo CSV

Route::get('/admin/estudiantes', function () {
    return view('ActExt.administrador.info_estudiantes');
})->name('estudiantes.info');

Route::get('/Pre-registro-TT', function () {
    return view('ActExt.estudiantes.formulario_TeamTask');
})->name('estudiantes.TeamTask');

Route::get('/recurseEC', function () {
    return view('ActExt.estudiantes.formulario_recurseEC');
})->name('estudiantes.RecurseEC');

Route::get('/registro', function () {
    return view('ActExt.estudiantes.formulario');
})->name('estudiantes.registro');

Route::get('/pdf', function () {
    return view('ActExt.administrador.pdf_asistencia');
})->name('admin.pdf');

Route::get('/pruebaPDF/{id}', [ExportController::class, 'exportPDF'])->name('exportPDF');


Route::post('/registroAlumno', [ConcentradoController::class, 'registro'])->name('registro.estudiante');
Route::post('/registroTeamTask', [TeamTaskController::class, 'registroTeamTask'])->name('registro.teamTask');
Route::post('/registroRecurseEC', [RecurseECController::class, 'rgistroRecurseEC'])->name('registro.recurseEC');


Route::get('/buscar-estudiantes', [ConcentradoController::class, 'buscarEstudiantes'])->name('buscar.estudiantes')->middleware('auth');
Route::get('/buscar-estudiantes/info', [ConcentradoController::class, 'buscarEstudianteInfo'])->name('buscar.estudiantes.info')->middleware('auth');

// Datos académicos
Route::resource('datos_academicos', DatosAcademicosController::class)->middleware('auth');

//Niveles
Route::get('/niveles/create', [NivelController::class, 'create'])->name('niveles.create')->middleware('auth');
Route::post('/niveles', [NivelController::class, 'store'])->name('niveles.store')->middleware('auth');
Route::get('/niveles', [NivelController::class, 'index'])->name('niveles.index')->middleware('auth');

//Reserva
// Ruta para consultar las reservaciones del estudiante
Route::get('/estudiante/reservaciones', [EstudiantesController::class, 'reservaciones'])->name('estudiantes.reservaciones')->middleware('auth');
// Ruta para cancelar una reservación
Route::patch('/estudiantes/reservaciones/cancelar/{id_reserva}', [ReservaController::class, 'cancelarReserva'])
    ->name('estudiantes.cancelarReserva')->middleware('auth');
// Ruta para cancelar todas las reservaciónes
Route::post('/actividades/{id}/cancelar-reservas', [ReservaController::class, 'cancelarReservacionesActividad'])
    ->name('actividades.cancelarReservas')->middleware('auth');

Route::get('/reservar', [EstudiantesController::class, 'reservar'])->name('estudiantes.reservar')->middleware('auth');
 
// Rutas para lista de asistencia
// Ruta para mostrar la interfaz de asistencia de una actividad específica
Route::get('/actividades/{id_cita}/asistencias', [AsistenciaController::class, 'mostrarAsistencias'])->name('actividades.asistencias')->middleware('auth');
Route::post('/actividades/{id_cita}/asistencias', [AsistenciaController::class, 'guardarAsistencias'])->name('actividades.guardarAsistencias')->middleware('auth');
//Autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form')->middleware('guest');// Ruta para mostrar el formulario de login
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');// Ruta para procesar el login

// Rutas protegidas, solo accesibles si el usuario está autenticado
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/tutoriales', function () {
        return view('ActExt.administrador.tutoriales');
    })->name('admin.tutoriales');

    Route::get('/profesor/actividades', [ProfesorController::class, 'actividadProfesor'])->name('prof.vista');
    
    Route::get('/estudiantes', [EstudiantesController::class, 'index'])->name('estudiantes.index'); // Solo autenticados
    
    Route::get('/admin', [ActividadController::class, 'index'])->name('admin.index'); // Solo autenticados
    
    Route::get('/listaAsistencia/{id}',[ActividadController::class,'listaAsis'])->name('asistencias.admin');
    
    Route::get('admin/listaTeamTask',[TeamTaskController::class,'listaRegistros'])->name('registros.teamTask');
    
    Route::get('admin/listaRecurseEC',[RecurseECController::class,'listaRegistros'])->name('registros.recurseEC');
    
    Route::get('/admin/dashboard', [ActividadController::class, 'index'])->name('admin.dashboard'); // Solo autenticados
    
    Route::get('/estudiantes/reservar', [EstudiantesController::class, 'reservar'])->name('estudiantes.reservar');
    
    Route::get('/estudiantes/reservar/{actividad}', [ReservaController::class, 'confirmarReserva'])->name('estudiantes.reservar.confirmar');
    
    //Route::get('/correo/{destinatario}/{aula}/{docente}/{fecha}', [ReservaController::class, 'enviarCorreo'])->name('prueba');
    Route::get('/estudiante/reservaciones', [ReservaController::class, 'misReservaciones'])->name('estudiantes.reservaciones');
    
    Route::get('/exportar-reservas', [ExportController::class, 'export'])->name('exportar.reservas');
    
    Route::get('/exportarTeamTask', [TeamTaskController::class, 'exportXLS'])->name('exportar.registrosTeamTask');
    
    Route::get('/exportarTeamTaskActual', [TeamTaskController::class, 'exportXLSActual'])->name('exportar.registrosTeamTaskActual');
    
    Route::get('/exportarRecurseEC', [RecurseECController::class, 'exportXLS'])->name('exportar.registrosRecurseEC');
    
    Route::get('/exportarRecurseECActual', [RecurseECController::class, 'exportXLSActual'])->name('exportar.registrosRecurseECActual');
    
    Route::get('/reservas', [ReservaController::class, 'index'])->name('estudiantes.reservas');
    
    Route::get('/personalizacion', [Personalizacion::class, 'cargarImagenes'])->name('admin.personalizacion');
    
    Route::post('/subir-imagen-carr', [Personalizacion::class, 'subirImagenCarrusel'])->name('subir.imagen.carrusel');
    
    Route::post('/subir-banner-gif', [Personalizacion::class, 'subirImagenGif'])->name('subir.banner.gif');
    
    Route::post('/agregar-opcion', [Personalizacion::class, 'agregarOpcion'])->name('agregar.opcion');
    
    Route::post('/editar-opcion/{id}', [Personalizacion::class, 'editarOpcion'])->name('editar.opcion');
    
    Route::get('/eliminar-opcion/{id}', [Personalizacion::class, 'eliminarOpcion'])->name('eliminar.opcion');
    
    Route::get('/eliminar-imagen-carr/{nombre}',[Personalizacion::class,'eliminarImagenCarrusel'])->name('eliminar.imagen.carrusel');
    
    Route::get('/eliminar-banner-gif/{nombre}',[Personalizacion::class,'eliminarBannerGif'])->name('eliminar.banner.gif');

    // Certificación (administrador)
    Route::get('/admin/certificacion', [CertificacionController::class, 'index'])->name('admin.certificacion.index');
    Route::get('/admin/certificacion/exportar', [CertificacionController::class, 'exportarExcel'])->name('certificacion.exportar');
    
    //Validaciones
    Route::post('/certificacion/aprobar/{id}/{accion}', [CertificacionController::class, 'aprobar'])->name('certificacion.aprobar');
    Route::get('/certificacion/dictamen/{id}', [CertificacionController::class, 'generarDictamen'])->name('certificacion.dictamen');


    // Certificación (estudiante)
    Route::get('/estudiantes/certificacionEST', [CertificacionEstudianteController::class, 'index'])->name('estudiantes.certificacionEST');
    Route::post('/estudiantes/certificacionEST/registrar', [CertificacionEstudianteController::class, 'store'])->name('certificacionEST.store');

});

// Cierra Sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/aviso',[EstudiantesController::class, 'aviso'])->name('aviso');

