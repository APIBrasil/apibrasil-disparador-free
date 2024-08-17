<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tags;
use App\Models\Disparos;
use App\Models\Templates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisparosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disparos = Disparos::orderBy('id', 'desc')->get();
        
        $templates = Templates::orderBy('id', 'desc')
        ->where('status', 'active')
        ->get();

        $tags = Tags::orderBy('id', 'desc')
        ->where('status', 'active')
        ->get();

        return view('admin.disparos')
        ->with('disparos', $disparos)
        ->with('templates', $templates)
        ->with('tags', $tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $disparo = new Disparos();

            $disparo->templates_id = $request->templates_id;
            $disparo->tag_id = $request->tag_id;
            $disparo->status = $request->status;
            $disparo->send_at = $request->send_at;

            $disparo->save();

            return response()->json([
                'error' => false,
                'message' => 'Disparo cadastrado com sucesso.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
