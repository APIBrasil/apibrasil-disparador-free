<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mensagens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoricoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mensagens = Mensagens::orderBy('id', 'desc')->get();

        return view('admin.historico')
        ->with('mensagens', $mensagens);
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
