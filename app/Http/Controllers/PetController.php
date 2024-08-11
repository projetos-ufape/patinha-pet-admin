<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use Illuminate\View\View;


class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pets = Pet::all();

        return view('pets.all', ['pets' => $pets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        $validate = $request->validated();
        $created = Pet::create($validate);

        if ($created) {
            return redirect()->route('pets.index')->with('message', 'criado com sucesso!');
        }
        return redirect()->back()->with('message', 'Erro na criação');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        return view('pets.show', ['pet' => $pet]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        return view('pets.edit', ['pet' => $pet]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $updated = $pet->update($request->except(['_token', '_method']));
      
        if ($updated) {
            return redirect()->back()->with('message', 'Atualizado com sucesso!');
        }
        return redirect()->back()->with('message', 'erro');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $deleted = $pet->delete();
        if ($deleted) {
            return redirect()->route('pets.index')->with('message', 'Pet excluido com sucesso');
        }
        return redirect()->route('pets.index')->with('message', 'Não foi possível excluir pet');
    }
}
