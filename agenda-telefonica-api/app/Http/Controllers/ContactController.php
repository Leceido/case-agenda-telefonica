<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PhpParser\Error;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (!$request->user()) {
            return response()->json([
                'status' => 401,
                'message' => 'Usuario não autenticado',
            ], 401);
        }
        $contacts = Contact::where('id_user', $request->user()->id)->get();
        $contacts->map(function ($contact) {
            if ($contact->image != null) {
                $contact->image = Storage::temporaryUrl($contact->image, now()->addMinutes(60));
            }
        });
        return response()->json([
            'status' => 200,
            'contacts' => $contacts,
            'user' => auth()->user()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        if (!auth()->user()) {
            return response()->json([
                'status' => 401,
                'message'=>'Usuario não autenticado',
                'user' => auth()->user()->id
            ], 401);
        }
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:255|min:3|string',
                'email' => 'required|max:255|string|email',
                'phone' => 'required|max:255|string',
            ], [
                'email' => "Email invalido",
                'phone' => "Telefone invalido",
                'name' => "Nome invalido"
            ]);


            $file = $request->file('image');
            if ($file) {
                $fileName = time().'_'.$file->getClientOriginalName();

                $res = Storage::put($fileName, file_get_contents($file));

                $contact = Contact::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'id_user' => auth()->user()->id,
                    'image' => $fileName
                ]);
            } else {
                $contact = Contact::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'phone' => $request->get('phone'),
                    'id_user' => auth()->user()->id
                ]);
            }

        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 403,
                'errors' => $errors,
                'request' => $request->all(),
                'message' => $e->getMessage()
            ], 403);
        }

        return response()->json([
            'status' => 201,
            'message' => "Contato criado com sucesso!",
            'contact' => $contact
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $contact = Contact::where('id', $id)->where('id_user', auth()->user()->id)->first();

        if(!$contact) {
            return response()->json([
                'status' => 404,
                'message' => "Contato não encontrado!"
            ], 404);
        }


        if ($contact->image != null) {
            $contact->image = Storage::temporaryUrl($contact->image, now()->addMinutes(60));
        }

        return response()->json([
            'status' => 200,
            'contact' => $contact
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        if (!auth()->user()) {
            return response()->json([
                'status' => 401,
                'message'=>'Usuario não autenticado',
                'user' => auth()->user()->id
            ]);
        }
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:255|min:3|string',
                'email' => 'required|max:255|string',
                'phone' => 'required|max:255|string',
            ], [
                'email' => "Email invalido",
                'phone' => "Telefone invalido",
                'name' => "Nome invalido"
            ]);
        } catch (ValidationException $e) {
            $errors = $e->errors();
            return response()->json([
                'status' => 403,
                'errors' => $errors,
                'request' => $request->all(),
                'message' => $e->getMessage()
            ], 403);
        }

        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'status' => 404,
                'message' => "Contato não encontrado!"
            ], 404);
        }
        if (auth()->user()->id != $contact->id_user) {
            return response()->json([
                'status' => 401,
                'message' => "Esse contato pertence a outro usuario!"
            ], 401);
        }

        $contact->update($request->except('image'));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time().'_'.$file->getClientOriginalName();
            $res = Storage::put($fileName, file_get_contents($file));
            $contact->image = $fileName;
            $contact->save();
        }

        return response()->json([
            'status' => 201,
            'message' => "Contato atualizado com sucesso!",
            'contact' => $contact,
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        if (!auth()->user()) {
            return response()->json([
                'status' => 401,
                'message'=>'Usuario não autenticado',
                'user' => auth()->user()->id
            ]);
        }
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'status' => 404,
                'message' => "Contato não encontrado!"
            ], 404);
        }
        if (auth()->user()->id != $contact->id_user) {
            return response()->json([
                'status' => 401,
                'message' => "Esse contato pertence a outro usuario!"
            ], 401);
        }
        Contact::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => "Contato removido com sucesso!",
        ]);
    }

    public function imageTest(Request $request)
    {

        $file = $request->file('image');
        $fileName = time().'_'.$file->getClientOriginalName();

        $res = Storage::put($fileName, file_get_contents($file));

        return response()->json([
            'status' => 200,
            'message' => $res
        ]);
    }
}
