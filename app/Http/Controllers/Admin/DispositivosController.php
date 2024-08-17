<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dispositivos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DispositivosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $dispositivos = Dispositivos::getAll();

        // dd($dispositivos);

        //if dispositivos->type != 'cellphone, or tablet'
        $dispositivos = array_filter($dispositivos, function($dispositivo) {
            return $dispositivo->type == 'cellphone' or $dispositivo->type == 'tablet';
        });

        return view('admin.dispositivos')->with('dispositivos', $dispositivos);
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
