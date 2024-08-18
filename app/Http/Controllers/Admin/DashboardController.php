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
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
