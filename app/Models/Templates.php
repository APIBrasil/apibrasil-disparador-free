<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'text',
        'path',
        'type',
        'status',
        'user_id'
    ];

}
