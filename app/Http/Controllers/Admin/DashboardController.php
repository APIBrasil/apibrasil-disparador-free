<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contatos;
use App\Models\Mensagens;
use App\Models\Dispositivos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $online = Dispositivos::online(Auth::user()->id);
        $offline = Dispositivos::offline(Auth::user()->id);

        $mensagens = Mensagens::orderBy('id', 'desc')
        ->where('status','sent')
        ->where('user_id', Auth::user()->id)
        ->count();

        $contatos = Contatos::orderBy('id', 'desc')
        ->where('user_id', Auth::user()->id)
        ->count();

        return view('admin.dashboard')
        ->with('user', $user)
        ->with('mensagens', $mensagens)
        ->with('contatos', $contatos)
        ->with('online', $online)
        ->with('offline', $offline);
    }

}
