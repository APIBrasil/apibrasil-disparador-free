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
        'mode'
    ];

    public function tag()
    {
        return $this->belongsTo(Tags::class, 'tag_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Mensagens::class, 'disparo_id', 'id');
    }

    public function messagesPending()
    {
        return $this->hasMany(Mensagens::class, 'disparo_id', 'id')->where('status', 'pending');
    }

    public function messagesSent()
    {
        return $this->hasMany(Mensagens::class, 'disparo_id', 'id')->where('status', 'sent');
    }

    public function getTemplates()
    {
        $templates = explode(',', $this->templates_id);
        $templates_name = [];

        foreach ($templates as $template_id) {
            $template = Templates::find(trim($template_id));

            if ($template) {
                $templates_name[] = $template->name;
            }
        }

        return implode(', ', $templates_name);
    }

}
