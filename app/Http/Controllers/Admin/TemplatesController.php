<?php

namespace App\Http\Controllers\Admin;

use App\Models\Templates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TemplatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Templates::orderBy('id', 'desc')->get();

        return view('admin.templates')
        ->with('templates', $templates);
    }

    public function store(Request $request)
    {
        try {
            
            $template = new Templates();
            $template->name = $request->name;
            $template->description = $request->description;
            $template->path = $request->path;
            $template->type = $request->type;
            $template->text = $request->text;
            $template->user_id = Auth::id();
            $template->status = $request->status;
            $template->save();

            return response()->json([
                'error' => false,
                'message' => 'Template criado com sucesso!'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show(string $id)
    {
        try {
            
            $template = Templates::find($id);

            return response()->json($template);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            
            $template = Templates::find($id);
            $template->name = $request->name;
            $template->description = $request->description;
            $template->path = $request->path;
            $template->type = $request->type;
            $template->text = $request->text;
            $template->status = $request->status;
            $template->save();

            return response()->json([
                'error' => false,
                'message' => 'Template atualizado com sucesso!'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy(string $id)
    {
        try {
            
            $template = Templates::find($id);
            $template->delete();

            return response()->json([
                'error' => false,
                'message' => 'Template deletado com sucesso!'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }
}
