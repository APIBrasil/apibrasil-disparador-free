<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Psr7\Request as RequestGuzzle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disparos extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'templates_id',
        'start_at',
        'end_at',
        'qt_pending',
        'qt_sent',
        'qt_error',
        'status',
        'user_id',
    ];

}
