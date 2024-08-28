<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Requests\CustomerSignUpRequest;
use App\Http\Api\Requests\CustomerUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function signup(CustomerSignUpRequest $request)
    {
        $data = $request->validated();

        /** @var User $user */
        $user = null;
        DB::transaction(function () use ($data, &$user) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'cpf' => $data['cpf'],
                'password' => Hash::make($data['password']),
            ]);

            if (isset($data['address'])) {
                $user->address()->create($data['address']);
            }

            $user->customer()->create([
                'phone_number' => $data['phone_number'],
            ]);
        });
        $token = $user->createToken('customer-api', ['customer'])->plainTextToken;

        return response()->json(compact('token'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if (! $user || ! $user->customer || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $token = $user->createToken('customer-api', ['customer'])->plainTextToken;

        return response()->json(compact('token'));
    }

    public function update(CustomerUpdateRequest $request) {
        
        $data = $request->validated();
        if (empty($data)) {
            return response()->json([
                'error' => 'Nenhum dado fornecido para atualização.'
            ], 422);
        }
        DB::transaction(function () use ($request, $data) {
            $userData = Arr::except($data, ['phone_number', 'address']);
            $request->user()->update($userData);
            
            if (isset($data['address'])) {
                if ($request->user()->address) {
                    $request->user()->address()->update($data['address']);
                } else {
                    $request->user()->address()->create($data['address']);
                }
            }

            if (isset($data['phone_number'])) {
                $request->user()->customer->update(['phone_number' => $data['phone_number']]);
            }

        });
        
        return response()->json(['message' => 'Atualizado com sucesso'], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
