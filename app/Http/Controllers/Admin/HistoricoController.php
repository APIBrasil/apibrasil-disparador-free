<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mensagens;
use App\Models\Dispositivos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoricoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $dispositivos = Dispositivos::getAll();

        $mensagens = Mensagens::orderBy('id', 'desc')
        ->where('user_id', Auth::id())
        ->get();

        $mensagensEnviadas = Mensagens::orderBy('id', 'desc')
        ->where('user_id', Auth::id())
        ->where('status', 'sent')
        ->get();

        $messagensError = Mensagens::orderBy('id', 'desc')
        ->where('user_id', Auth::id())
        ->where('status', 'error')
        ->get();

        return view('admin.historico')
        ->with('dispositivos', $dispositivos)
        ->with('mensagens', $mensagens)
        ->with('mensagensEnviadas', $mensagensEnviadas)
        ->with('messagensError', $messagensError);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
