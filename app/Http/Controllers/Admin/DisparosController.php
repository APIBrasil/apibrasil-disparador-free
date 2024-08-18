<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tags;
use App\Models\Disparos;
use App\Models\Mensagens;
use App\Models\Templates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

            $disparo->templates_id = implode(',', $request->templates_id);
            $disparo->name = $request->name;
            $disparo->description = $request->description;
            $disparo->tag_id = $request->tag_id;
            $disparo->status = $request->status;
            $disparo->user_id = Auth::user()->id;

            $disparo->save();

            $contatos = Tags::find($request->tag_id)->contatos;

            foreach ($contatos as $contato) {

                $template_random_id = $request->templates_id[array_rand($request->templates_id)];
                
                Mensagens::create([
                    'contact_id' => $contato->id,
                    'template_id' => $template_random_id,
                    'tag_id' => $request->tag_id,
                    'user_id' => Auth::user()->id,
                    'disparo_id' => $disparo->id,
                    'status' => 'pending',
                ]);

            }

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
        $disparo = Disparos::find($id);

        return response()->json($disparo, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $disparo = Disparos::find($id);

            $disparo->templates_id = $request->templates_id;
            $disparo->name = $request->name;
            $disparo->description = $request->description;
            $disparo->tag_id = $request->tag_id;
            $disparo->status = $request->status;

            $disparo->save();

            return response()->json([
                'error' => false,
                'message' => 'Disparo atualizado com sucesso.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $disparo = Disparos::find($id);

            $disparo->delete();

            return response()->json([
                'error' => false,
                'message' => 'Disparo excluído com sucesso.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
