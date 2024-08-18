<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tags;
use App\Models\Contatos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\UploadContactsJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContatosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contatos = Contatos::all();
        $tags = Tags::orderBy('id', 'desc')->where('status', 'active')->get();

        return view('admin.contatos')
        ->with('contatos', $contatos)
        ->with('tags', $tags);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'number' => 'required|max:13|min:11',
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'number.required' => 'O campo número é obrigatório.',
                'number.max' => 'O campo número deve ter no máximo 13 caracteres.',
                'number.min' => 'O campo número deve ter no mínimo 11 caracteres.',
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
            
            $contato = new Contatos();
            
            $contato->name = $request->name;
            $contato->number = $request->number;
            $contato->tag_id = $request->tag_id;
            $contato->user_id = Auth::user()->id;

            $contato->save();

            return response()->json([
                'error' => false,
                'message' => 'Contato cadastrado com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $contato = Contatos::find($id);
            return response()->json($contato);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }


    //upload
    public function upload(Request $request)
    {
        try {

            $validation = Validator::make($request->all(), [
                'file' => 'required|mimes:csv,txt',
            ], [
                'file.required' => 'O campo arquivo é obrigatório.',
                'file.mimes' => 'O arquivo deve ser do tipo csv ou txt.',
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validation->errors()
                ], 400);
            }

            $file = $request->file('file');
            $path = $file->store('uploads');

            $file = fopen(storage_path('app/' . $path), 'r');

            while (($line = fgetcsv($file)) !== FALSE) {

                //check number exists
                $numbers = [];
                $contato = Contatos::where('number', $line[1])->first();
                if ($contato) {
                    $numbers[] = $line[1];
                }

                $contato = new Contatos();
                $contato->name = $line[0];
                $contato->number = $line[1];
                $contato->tag_id = $line[2];
                $contato->user_id = Auth::user()->id;
                $contato->save();
            }

            fclose($file);

            //UploadContactsJob::dispatch(Auth::user()->id, $path);

            return redirect()->route('contatos.index')->with('success', 'Contatos importados com sucesso, duplicados: ' . implode(', ', $numbers));

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'number' => 'required|max:13|min:11',
            ], [
                'name.required' => 'O campo nome é obrigatório.',
                'number.required' => 'O campo número é obrigatório.',
                'number.max' => 'O campo número deve ter no máximo 13 caracteres.',
                'number.min' => 'O campo número deve ter no mínimo 11 caracteres.',
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
            
            $contato = Contatos::find($id);

            $contato->name = $request->name;
            $contato->number = $request->number;
            $contato->tag_id = $request->tag_id;
            $contato->user_id = Auth::user()->id;

            $contato->save();

            return response()->json([
                'error' => false,
                'message' => 'Contato atualizado com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contato = Contatos::find($id);
            $contato->delete();

            return response()->json([
                'error' => false,
                'message' => 'Contato deletado com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
