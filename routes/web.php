<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAuthMiddleware;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DispositivosController;

#router group

Route::group(['middleware' => CheckAuthMiddleware::class], function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/disparos', function () {
        return view('admin.disparos');
    });

    Route::get('/dispositivos', [DispositivosController::class, 'index'])->name('dispositivos');

    Route::get('/conexoes', function () {
        return view('admin.conexoes');
    });

    Route::get('/contatos', function () {
        return view('admin.contatos');
    });

    Route::get('/historico', function () {
        return view('admin.historico');
    });

    Route::get('/templates', function () {
        return view('admin.templates');
    });

});

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('auth', [LoginController::class, 'auth'])->name('auth');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

//reset-password
Route::get('reset-password', function () {
    return view('reset-password');
});

//signup
Route::get('signup', function () {
    return view('signup');
});

//docs
Route::get('docs', function () {
    return view('docs');
});

//help
Route::get('blank', function () {
    return view('blank');
});
