<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAuthMiddleware;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ContatosController;
use App\Http\Controllers\Admin\DisparosController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HistoricoController;
use App\Http\Controllers\Admin\TemplatesController;
use App\Http\Controllers\Admin\DispositivosController;

#router group

Route::group(['middleware' => CheckAuthMiddleware::class], function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::group(['prefix' => 'tags'], function () {
        Route::get('/', [TagsController::class, 'index'])->name('tags.index');
        Route::get('/{id}/show', [TagsController::class, 'show'])->name('tags.show');
        Route::post('/store', [TagsController::class, 'store'])->name('tags.store');
        Route::patch('/{id}/update', [TagsController::class, 'update'])->name('tags.update');
        Route::delete('/{id}/destroy', [TagsController::class, 'destroy'])->name('tags.destroy');
    });

    Route::group(['prefix' => 'contatos'], function () {
        Route::get('/', [ContatosController::class, 'index'])->name('contatos.index');
        Route::get('/{id}/show', [ContatosController::class, 'show'])->name('contatos.show');
        Route::post('/store', [ContatosController::class, 'store'])->name('contatos.store');
        Route::post('/upload', [ContatosController::class, 'upload'])->name('contatos.upload');
        Route::patch('/{id}/update', [ContatosController::class, 'update'])->name('contatos.update');
        Route::delete('/{id}/destroy', [ContatosController::class, 'destroy'])->name('contatos.destroy');
    });

    Route::group(['prefix' => 'dispositivos'], function () {
        Route::get('/', [DispositivosController::class, 'index'])->name('dispositivos.index');
        Route::post('/store', [DispositivosController::class, 'store'])->name('dispositivos.store');
        Route::get('/{id}/show', [DispositivosController::class, 'show'])->name('dispositivos.show');
        Route::patch('/{id}/update', [DispositivosController::class, 'update'])->name('dispositivos.update');
        Route::post('/{device_token}/start', [DispositivosController::class, 'start'])->name('dispositivos.start');
        Route::delete('/{search}/destroy', [DispositivosController::class, 'destroy'])->name('dispositivos.destroy');
    });

    Route::group(['prefix' => 'templates'], function () {
        Route::get('/', [TemplatesController::class, 'index'])->name('templates.index');
        Route::get('/{id}/show', [TemplatesController::class, 'show'])->name('templates.show');
        Route::post('/store', [TemplatesController::class, 'store'])->name('templates.store');
        Route::patch('/{id}/update', [TemplatesController::class, 'update'])->name('templates.update');
        Route::delete('/{id}/destroy', [TemplatesController::class, 'destroy'])->name('templates.destroy');
    });
    
    Route::group(['prefix' => 'disparos'], function () {
        Route::get('/', [DisparosController::class, 'index'])->name('disparos.index');
        Route::get('/{id}/show', [DisparosController::class, 'show'])->name('disparos.show');
        Route::post('/store', [DisparosController::class, 'store'])->name('disparos.store');
        Route::patch('/{id}/update', [DisparosController::class, 'update'])->name('disparos.update');
        Route::delete('/{id}/destroy', [DisparosController::class, 'destroy'])->name('disparos.destroy');
    });

    Route::get('/historico', [HistoricoController::class, 'index'])->name('historico');

});

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('auth', [LoginController::class, 'auth'])->name('auth');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
