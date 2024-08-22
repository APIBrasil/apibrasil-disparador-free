<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mensagens;
use App\Models\Dispositivos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HistoricoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $mensagens = Mensagens::select('id', 'user_id')
        ->where('user_id', Auth::id())
        ->count();

        $mensagensEnviadas = Mensagens::select('id', 'user_id')
        ->where('user_id', Auth::id())
        ->where('status', 'sent')
        ->count();

        $mensagensPendentes = Mensagens::select('id', 'user_id')
        ->where('user_id', Auth::id())
        ->where('status', 'pending')
        ->count();

        $messagensError = Mensagens::select('id', 'user_id')
        ->where('user_id', Auth::id())
        ->where('status', 'error')
        ->count();

        return view('admin.historico')
        ->with('mensagensEnviadas', $mensagensEnviadas)
        ->with('mensagensPendentes', $mensagensPendentes)
        ->with('mensagens', $mensagens)
        ->with('messagensError', $messagensError);
    }

    public function dataTables()
    {
        
        $mensagens = Mensagens::where('user_id', Auth::id())
        ->orderBy('id', 'desc')
        ->with(['contato' => function($query){
            $query->select('id', 'number'); // Include 'id' to avoid issues with missing columns
        }, 'tag' => function($query){
            $query->select('id', 'color', 'name'); // Include 'id' to avoid issues with missing columns
        }])
        ->with('template', function($query){
            $query->select('id', 'name'); // Include 'id' to avoid issues with missing columns
        })
        ->get();


        return DataTables::of($mensagens)->make(true);

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
