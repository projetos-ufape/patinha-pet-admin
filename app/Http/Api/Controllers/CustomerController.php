<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Requests\CustomerUpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Get info
     */
    public function index(Request $request)
    {

        $user = $request->user();
        $phone_number = $request->user()->customer->phone_number;
        $address = $request->user()->address;

        return response()->json(['user' => [
            'name' => $user->name,
            'email' => $user->email,
            'cpf' => $user->cpf,
            'phone_number' => $phone_number,
            'address' => $address ? [
                'cep' => $address->cep,
                'city' => $address->city,
                'state' => $address->state,
                'street' => $address->street,
                'district' => $address->district,
                'number' => $address->number,
                'complement' => $address->complement,
            ] : null,
        ]], 200);

    }

    /**
     * Update info
     */
    public function update(CustomerUpdateRequest $request)
    {
        $data = $request->validated();
        if (empty($data)) {
            return response()->json([
                'error' => 'Nenhum dado fornecido para atualização.',
            ], 422);
        }

        DB::transaction(function () use ($request, $data) {
            $userData = Arr::except($data, ['phone_number', 'address', 'cpf', 'email']);
            $user = $request->user();
            $user->update($userData);

            if (isset($data['phone_number'])) {
                $user->customer->update(['phone_number' => $data['phone_number']]);
            }

            if (isset($data['address'])) {
                if ($user->address !== null) {
                    $user->address()->update($data['address']);
                } else {
                    $user->address()->create($data['address']);    
                }
            }
        });

        return response()->json(['message' => 'Atualizado com sucesso'], 200);

    }
}
