<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tags;
use App\Models\Contatos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tags::all();

        return view('admin.tags')
        ->with('tags', $tags);

    }

    public function store(Request $request)
    {
        try {
            
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required|max:255|min:2',
                'status' => 'required',
                'color' => 'required',
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'description.required' => 'O campo descrição é obrigatório.',
                'description.max' => 'O campo descrição deve ter no máximo 255 caracteres.',
                'description.min' => 'O campo descrição deve ter no mínimo 2 caracteres.',
                'status.required' => 'O campo status é obrigatório.',
                'color.required' => 'O campo cor é obrigatório.',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validation->errors()
                ], 400);
            }

            $tag = new Tags();

            $tag->name = $request->name;
            $tag->description = $request->description;
            $tag->color = $request->color;
            $tag->user_id = Auth::id();
            $tag->status = $request->status;
            
            $tag->save();

            return response()->json([
                'error' => false,
                'message' => 'Tag criada com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show(string $id)
    {
        try {

            $tag = Tags::find($id);

            return response()->json($tag);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {

            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required|max:255|min:2',
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'description.required' => 'O campo descrição é obrigatório.',
                'description.max' => 'O campo descrição deve ter no máximo 255 caracteres.',
                'description.min' => 'O campo descrição deve ter no mínimo 2 caracteres.',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validation->errors()
                ], 400);
            }

            $request->merge([
                'number' => preg_replace('/\D/', '', $request->number)
            ]);
            
            $tag = Tags::find($id);

            $tag->name = $request->name;
            $tag->description = $request->description;
            $tag->color = $request->color;
            $tag->user_id = Auth::id();
            $tag->status = $request->status;
            
            $tag->save();

            return response()->json([
                'error' => false,
                'message' => 'Tag atualizada com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }   
    }
    
    public function destroy(string $id)
    {
        try {

            $tag = Tags::find($id);
            $tag->delete();

            return response()->json([
                'error' => false,
                'message' => 'Tag removida com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
