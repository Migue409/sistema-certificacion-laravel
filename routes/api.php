<?php

use App\Http\Controllers\ActividadController;

use App\Http\Controllers\AsistenciaController;

use App\Http\Controllers\CoordinacionApi;

use App\Http\Controllers\ReservaController;

use Illuminate\Support\Facades\Route;

Route::get('/actividadesProfesor', [CoordinacionApi::class, 'ajaxProfesor'])->name('profesor.index'); // Solo autenticados

Route::get('/admin/dashboard/ajax', [ActividadController::class, 'ajax'])->name('admin.dashboard.ajax'); // Solo autenticados

Route::get('/ajax/docente/{fecha}/{hora}', [ActividadController::class, 'validacionDocente']); //Ruta que verfica las horas disponibles

Route::get('/actividades/{id_cita}/asistencias/ajax', [AsistenciaController::class, 'ajax'])->name('actividades.asistencias.ajax')->middleware('auth');//ajax

Route::get('/reservas/ajax', [ReservaController::class, 'ajax'])->name('estudiantes.reservas.ajax');

