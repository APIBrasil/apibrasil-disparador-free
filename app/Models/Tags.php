<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'status',
        'user_id',
    ];

    public function contatos()
    {
        return $this->hasMany(Contatos::class, 'tag_id', 'id');
    }
    
}
