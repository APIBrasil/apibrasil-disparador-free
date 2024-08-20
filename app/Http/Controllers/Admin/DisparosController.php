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
    
    public function index()
    {
        $disparos = Disparos::orderBy('id', 'desc')
        ->where('user_id', Auth::user()->id)
        ->get();
        
        $templates = Templates::orderBy('id', 'desc')
        ->where('status', 'active')
        ->where('user_id', Auth::user()->id)
        ->get();

        $tags = Tags::orderBy('id', 'desc')
        ->where('status', 'active')
        ->where('user_id', Auth::user()->id)
        ->get();

        return view('admin.disparos')
        ->with('disparos', $disparos)
        ->with('templates', $templates)
        ->with('tags', $tags);
    }

    public function store(Request $request)
    {
        try {

            $disparo = new Disparos();

            $disparo->templates_id = implode(',', $request->templates_id);
            $disparo->name = $request->name;
            $disparo->description = $request->description;
            $disparo->tag_id = $request->tag_id;
            $disparo->user_id = Auth::user()->id;
            $disparo->status = $request->status;
            $disparo->mode = $request->mode;

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

    public function show(string $id)
    {
        $disparo = Disparos::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();

        return response()->json($disparo, 200);
    }

    public function update(Request $request, string $id)
    {
        try {

            $disparo = Disparos::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();

            $disparo->templates_id = implode(',', $request->templates_id);

            $disparo->name = $request->name;
            $disparo->description = $request->description;
            $disparo->tag_id = $request->tag_id;
            $disparo->user_id = Auth::user()->id;
            $disparo->status = $request->status;
            $disparo->mode = $request->mode;

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

    public function destroy(string $id)
    {
        try {

            $disparo = Disparos::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();
            
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
