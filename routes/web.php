<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\AuthController;

// =============================================
// HOME
// =============================================
Route::get('/', function () {
    return redirect()->route('solicitudes.index');
})->name('home');

// =============================================
// LOGIN / REGISTER
// =============================================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// =============================================
// RUTAS PROTEGIDAS
// =============================================
Route::middleware(['auth'])->group(function () {

    // =========================================
    // SOLICITUDES
    // =========================================

    // LISTADO
    Route::get('/solicitudes', [SolicitudController::class, 'index'])
        ->name('solicitudes.index');

    // CREAR (VISTA)
    Route::get('/solicitudes/crear', function () {
        return view('solicitudes.formulario_completo');
    })->name('solicitudes.crear');

    // GUARDAR
    Route::post('/solicitudes/store-completo', [SolicitudController::class, 'storeCompleto'])
        ->name('solicitudes.storeCompleto');

    // ----- RRHH -----
    Route::get('/solicitudes/rrhh/{id}', [SolicitudController::class, 'vistaRRHH'])
        ->name('solicitudes.vistaRRHH');

    Route::post('/solicitudes/rrhh/{id}', [SolicitudController::class, 'aprobarRRHH'])
        ->name('solicitudes.aprobarRRHH');

    // ----- AUDITORÍA -----
    Route::get('/solicitudes/auditoria/{id}', [SolicitudController::class, 'vistaAuditoria'])
        ->name('solicitudes.vistaAuditoria');

    Route::post('/solicitudes/auditoria/{id}', [SolicitudController::class, 'aprobarAuditoria'])
        ->name('solicitudes.aprobarAuditoria');

    // ----- TI -----
    Route::get('/solicitudes/ti/{id}', [SolicitudController::class, 'vistaTI'])
        ->name('solicitudes.vistaTI');

    Route::post('/solicitudes/ti/{id}', [SolicitudController::class, 'aprobarTI'])
        ->name('solicitudes.aprobarTI');

    // ----- TI2 -----
    Route::get('/solicitudes/ti2/{id}', [SolicitudController::class, 'vistaTI2'])
        ->name('solicitudes.vistaTI2');

    Route::post('/solicitudes/ti2/instalar/{id}', [SolicitudController::class, 'guardarInstalacionTI2'])
        ->name('solicitudes.guardarInstalacionTI2');

    // ----- SISTEMAS -----
    Route::get('/solicitudes/sistemas/{id}', [SolicitudController::class, 'vistaSistemas'])
        ->name('solicitudes.vistaSistemas');

    Route::post('/solicitudes/sistemas/instalar/{id}', [SolicitudController::class, 'guardarInstalacionSistemas'])
        ->name('solicitudes.guardarInstalacionSistemas');

    // ----- VER DETALLE -----
    Route::get('/solicitudes/detalle/{id}', [SolicitudController::class, 'verDetalle'])
        ->name('solicitudes.detalle');

    // ----- EXPORTAR PDF -----
    Route::get('/solicitudes/pdf/{id}', [SolicitudController::class, 'exportarPDF'])
        ->name('solicitudes.pdf');

    // =========================================
    // NOTIFICACIONES
    // =========================================

    // LISTADO
    Route::get('/notificaciones', [NotificacionController::class, 'index'])
        ->name('notificaciones.index');

    // CREAR (STORE)
    Route::post('/notificaciones', [NotificacionController::class, 'store'])
        ->name('notificaciones.store');

    // MARCAR UNA COMO LEÍDA
    Route::post('/notificaciones/marcar-leido/{id}', [NotificacionController::class, 'marcarLeido'])
        ->name('notificaciones.leido');

    // MARCAR VARIAS COMO LEÍDAS
    Route::post('/notificaciones/leido-multiple', [NotificacionController::class, 'marcarLeidoMultiple'])
        ->name('notificaciones.leidoMultiple');

    // ELIMINAR VARIAS
    Route::post('/notificaciones/eliminar', [NotificacionController::class, 'eliminarMultiples'])
        ->name('notificaciones.eliminar');

    // POLL (AJAX)
    Route::get('/notificaciones/poll', [NotificacionController::class, 'poll'])
        ->name('notificaciones.poll');
});

