<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\RoleController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
    Route::get('/projects/show/{id}', [ProjectsController::class, 'show'])->name('projects.show');
    Route::get('/projects/history', [ProjectsController::class, 'auditTrail'])->name('projects.history');
    Route::post('/projects/export', [ProjectsController::class, 'export'])->name('projects.export');
    Route::post('/projects/import', [ProjectsController::class, 'importExcel'])->name('projects.import');
    
    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks');
    Route::get('/tasks/show/{id}', [TasksController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/history', [TasksController::class, 'auditTrail'])->name('tasks.history');
    Route::post('/tasks/export', [TasksController::class, 'export'])->name('tasks.export');
    Route::post('/tasks/import', [TasksController::class, 'importExcel'])->name('tasks.import');
    
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/roles/history', [RoleController::class, 'auditTrail'])->name('roles.history');
    
    Route::middleware(['role:manager|admin'])->group(function () {
        Route::get('/clients', [ClientController::class, 'index'])->name('clients');
        Route::get('/clients/show/{id}', [ClientController::class, 'show'])->name('clients.show');
        Route::get('/clients/history', [ClientController::class, 'auditTrail'])->name('clients.history');
        Route::post('/clients/export', [ClientController::class, 'export'])->name('clients.export');
        Route::post('/clients/import', [ClientController::class, 'importExcel'])->name('clients.import');
    });
    
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/show/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/history', [UserController::class, 'auditTrail'])->name('users.history');
        Route::post('/users/export', [UserController::class, 'export'])->name('users.export');
        Route::post('/users/import', [UserController::class, 'importExcel'])->name('users.import');

    });


});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/api.php';

