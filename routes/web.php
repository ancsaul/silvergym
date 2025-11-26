<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\VisitaController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/cambiar-contrasena', [AuthController::class, 'showChangePassword'])->name('password.change');
Route::post('/cambiar-contrasena', [AuthController::class, 'changePassword'])->name('password.change.post');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users management
    Route::resource('usuarios', UserController::class);

    // Membresías management
    Route::resource('membresias', MembresiaController::class);

    // Miembros management
    Route::resource('miembros', MiembroController::class);
    Route::get('/miembros/{miembro}/opciones', [MiembroController::class, 'opciones'])->name('miembros.opciones');
    Route::get('/miembros/{miembro}/credencial', [MiembroController::class, 'generarCredencial'])->name('miembros.credencial');

    // Pagos management
    Route::resource('pagos', PagoController::class);

    // Visitas management
    Route::resource('visitas', VisitaController::class);
    Route::post('/visitas/registrar-entrada', [VisitaController::class, 'registrarEntrada'])->name('visitas.entrada');
    Route::post('/visitas/{visita}/registrar-salida', [VisitaController::class, 'registrarSalida'])->name('visitas.salida');
});
