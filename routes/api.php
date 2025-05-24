<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HandleDownload;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/create/project',  [ProjectsController::class, 'store'])->name('projects.store');
    Route::put('/edit/project/{id}',  [ProjectsController::class, 'update'])->name('projects.update');
    Route::post('projects/{projectId}/upload-attachment',  [ProjectsController::class, 'uploadAttachments'])->name('projects.upload-attachment');
    Route::delete('/delete/project/{id}',  [ProjectsController::class, 'destroy'])->name('projects.destroy');
    
    Route::get('/excel/download/{id}', [HandleDownload::class, 'downloadExport'])->name('download.export');
    
    Route::post('/create/role',  [RoleController::class, 'store'])->name('role.store');
    Route::post('/roles/{roleId}/sync-permissions', [RoleController::class, 'assignPermissions'])->name('roles.sync-permissions');
    Route::put('/update/role/{uuid}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/delete/role/{uuid}', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::post('/create/tasks',  [TasksController::class, 'store'])->name('task.store');
    Route::post('/tasks/{taskId}/upload-attachment',  [TasksController::class, 'uploadAttachment'])->name('task.upload-attachment');
    Route::put('/update/tasks/{id}',  [TasksController::class, 'update'])->name('task.update');
    Route::delete('/delete/tasks/{id}',  [TasksController::class, 'destroy'])->name('task.destroy');

    Route::post('/create/client',  [ClientController::class, 'store'])->name('clients.store');
    Route::put('/update/client/{id}',  [ClientController::class, 'update'])->name('clients.update');
    Route::put('/update/client/{id}',  [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/delete/client/{id}',  [ClientController::class, 'destroy'])->name('clients.destroy');

    Route::put('/update/user/{id}',  [UserController::class, 'update'])->name('user.update');
    Route::delete('/destroy/user/{id}',  [UserController::class, 'destroy'])->name('user.destroy');
});



