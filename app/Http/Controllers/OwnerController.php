<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index( Request $request )
    {
        $owners = Owner::all();

        return response()->json($owners, 200);

    }

    public function by_gender( Request $request, $gender)
    {

        if ($gender == 'all') {
            $owners = Owner::all();
        }
        else {
            $owners = Owner::where('gender', $gender)->get();
        }

        return response()->json($owners, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:owners',
            'cpf' => 'required|min:11|max:11|unique:owners',
            'email' => 'email',
            'phone' => 'required',
            'birth' => 'required'
        ], [
            'required' => 'O campo :attribute deve ser preenchido',
            'unique' => 'O :attribute já está cadastrado', 
            'name.min' => 'O campo nome deve ter no mínimo 3 caracteres',
            'cpf' => 'O cpf deve ter 11 caracteres',
            'email' => 'O email deve ser válido'
        ]);

        $owner = new Owner();
        $owner->name = $request->name;
        $owner->email = $request->email;

        // Remove all special characters and spaces
        $owner->cpf = preg_replace('/[^A-Za-z0-9]/', '', $request->cpf);
        $owner->phone = preg_replace('/[^A-Za-z0-9]/', '', $request->phone);

        $owner->birth_date = $request->birth;
        $owner->gender = $request->gender;

        $owner->save();

        return response()->json($owner, 201);
    }

    public function show(Owner $owner)
    {
        //
    }

    public function edit(Owner $owner)
    {
        //
    }

    public function update(Request $request, Owner $owner)
    {
        //
    }

    public function destroy(Owner $owner)
    {
        //
    }
}
