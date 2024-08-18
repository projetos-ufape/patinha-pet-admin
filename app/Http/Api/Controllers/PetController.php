<?php

namespace App\Http\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Api\Requests\StorePetApiRequest;
use App\Http\Api\Requests\UpdatePetApiRequest;
use App\Http\Api\Resources\PetResource;
use App\Models\Pet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function update(UpdatePetApiRequest $request, string $id) {
        try {
            $pet = Pet::findOrFail($id);
            $validated = $request->validated();
            $updated = $pet->update($validated);
            if ($updated) {
                return response()->json(['message' => 'Atualizado com sucesso'], 200);
            }
            return response()->json(['error' => 'Não foi possível atualizar.'], 400);
        } catch (ModelNotFoundException | NotFoundHttpException $e) {
            return response()->json(['error' => 'Pet não encontrado.'], 404);
        }
    }

    public function destroy(string $id) {
        try {
            $pet = Pet::findOrFail($id);
            $deleted = $pet->delete();
            if ($deleted) {
                return response()->json(['message' => 'Pet excluído com sucesso.'], 200);
            }
            return response()->json(['error' => 'Não foi possível excluir o pet'], 400);
        } catch (ModelNotFoundException | NotFoundHttpException $e) {
            return response()->json(['error' => 'Pet não encontrado.'], 404);
        }
    }
    
}
