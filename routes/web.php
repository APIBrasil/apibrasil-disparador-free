<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
});

Route::get('/disparos', function () {
    return view('admin.disparos');
});

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

Route::get('login', function () {
    return view('login');
});

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

//orders
Route::get('orders', function () {
    return view('orders');
});

//orders
Route::get('consumption', function () {
    return view('consumption');
});

//help
Route::get('help', function () {
    return view('help');
});

//help
Route::get('blank', function () {
    return view('blank');
});
