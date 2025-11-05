<?php

use App\Http\Controllers\ActividadController;

use App\Http\Controllers\AsistenciaController;

use App\Http\Controllers\CoordinacionApi;

use App\Http\Controllers\ReservaController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CertificacionController;

use App\Http\Controllers\CertificacionESTController;

Route::get('/actividadesProfesor', [CoordinacionApi::class, 'ajaxProfesor'])->name('profesor.index'); // Solo autenticados

Route::get('/admin/dashboard/ajax', [ActividadController::class, 'ajax'])->name('admin.dashboard.ajax'); // Solo autenticados

Route::get('/ajax/docente/{fecha}/{hora}', [ActividadController::class, 'validacionDocente']); //Ruta que verfica las horas disponibles

Route::get('/actividades/{id_cita}/asistencias/ajax', [AsistenciaController::class, 'ajax'])->name('actividades.asistencias.ajax')->middleware('auth');//ajax

Route::get('/reservas/ajax', [ReservaController::class, 'ajax'])->name('estudiantes.reservas.ajax');

//administrador
    // Vista principal del módulo (panel de certificados)
Route::get('/admin/certificacion-ingles', [CertificacionController::class, 'index'])->name('admin.certificacion.ingles');

    // Ruta para mostrar el formulario de validación (modal o página)
Route::get('/admin/certificacion-ingles/validar/{id}', [CertificacionController::class, 'showValidationForm'])->name('admin.certificacion.ingles.validar');

    // Ruta para procesar la validación del certificado
Route::post('/admin/certificacion-ingles/validar', [CertificacionController::class, 'validarCertificado'])->name('admin.certificacion.ingles.validar.post');

//estudiante
Route::prefix('estudiante')->middleware('auth')->group(function () {
    // Vista principal del módulo (certificado de inglés)
    Route::get('/estudiantes/certificacion', [CertificacionESTController::class, 'index'])->name('estudiantes.certificacion');

    //Route::post('/estudiantes/certificacion', [CertificacionESTController::class, 'store'])->name('estudiantes.certificacion.store');
});
