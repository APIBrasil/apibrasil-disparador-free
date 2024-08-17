<?php

namespace App\Http\Controllers\Admin;

use App\Models\Templates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        try {
            
            $template = new Templates();
            $template->name = $request->name;
            $template->description = $request->description;
            $template->path = $request->path;
            $template->type = $request->type;
            $template->text = $request->text;
            // $template->user_id = auth()->user()->id;
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

    /**
     * Display the specified resource.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
