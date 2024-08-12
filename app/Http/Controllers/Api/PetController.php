<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePetApiRequest;
use App\Http\Requests\Api\UpdatePetApiRequest;
use App\Http\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PetController extends Controller
{
    public function index() {
        $pets = Pet::get();

        return PetResource::collection($pets);
    }

    public function store(StorePetApiRequest $request) {
        $validated = $request->validated();

        $pet = Pet::create($validated);

        return response()->json(['message' => 'Criado com sucesso', 'id' => $pet->id], 201);
    }

    public function show(string $id) {
        try {
            $pet = Pet::findOrFail($id);
            return new PetResource($pet);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pet não encontrado.'], 404);
        }
    }

    public function update(UpdatePetApiRequest $request, Pet $pet) {

        $validated = $request->validated();

        $updated = $pet->update($validated);
        if ($updated) {
            return response()->json(['message' => 'Atualizado com sucesso'], 200);
        }
        return response()->json(['error' => 'Não foi possível atualizar.'], 400);
    }

    public function destroy(string $id) {
        try {
            $pet = Pet::findOrFail($id);
            $deleted = $pet->delete();
            if ($deleted) {
                return response()->json(['message' => 'Pet excluído com sucesso.'], 200);
            }
            return response()->json(['error' => 'Não foi possível excluir o pet'], 400);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pet não encontrado.'], 404);
        }
    }
    
}
