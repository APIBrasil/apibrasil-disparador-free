<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WhatsAppController;

Route::get('/sendText', [WhatsAppController::class, 'sendText'])->name('sendText');
    