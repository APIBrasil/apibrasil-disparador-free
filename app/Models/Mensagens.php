<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagens extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'template_id',
        'tag_id',
        'user_id',
        'disparo_id',
        'send_at',
        'status',
    ];

    public function contato()
    {
        return $this->belongsTo(Contatos::class, 'contact_id', 'id');
    }

    public function template()
    {
        return $this->belongsTo(Templates::class, 'template_id', 'id');
    }

    public function tag()
    {
        return $this->belongsTo(Tags::class, 'tag_id', 'id');
    }

    public function disparo()
    {
        return $this->belongsTo(Disparos::class, 'disparo_id', 'id');
    }
}
