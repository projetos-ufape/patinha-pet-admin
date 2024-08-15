<?php

namespace App\Http\Controllers;

use App\Enums\AddressState;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$users = User::all();

		return response()->json($users); // remove later
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
		$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
			'cpf' => ['required', 'string'],
			'salary' => ['required', 'numeric'],
			'admission_date' => ['required', 'date', 'date_format:Y-m-d'],
			'state' => ['required', Rule::enum(AddressState::class)],
			'city' => ['required', 'string'],
			'district' => ['required', 'string'],
			'street' => ['required', 'string'],
			'number' => ['required', 'integer'],
			'complement' => ['string'],
			'cep' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
			'cpf' => $request->cpf,
			'salary' => $request->salary,
			'admission_date' => $request->admission_date,
        ]);

		Address::create([
            'state' => $request->state,
            'city' => $request->city,
			'district' => $request->district,
			'street' => $request->street,
			'number' => $request->number,
			'cep' => $request->cep,
			'complement' => $request->complement,
			'user_id' => $user->id,
        ]);

		return response()->json($user); // remove later
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->first();

		return response()->json($user); // remove later
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
		$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
			'cpf' => ['required', 'string'],
			'salary' => ['required', 'numeric'],
			'admission_date' => ['required', 'date', 'date_format:Y-m-d'],
			'state' => ['required', Rule::enum(AddressState::class)],
			'city' => ['required', 'string'],
			'district' => ['required', 'string'],
			'street' => ['required', 'string'],
			'number' => ['required', 'integer'],
			'complement' => ['string'],
			'cep' => ['required', 'string'],
        ]);

        $user = User::where('id', $id)->first();
		$address = Address::where('user_id', $id)->first();

		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = $request->password;
		$user->cpf = $request->cpf;
		$user->salary = $request->salary;
		$user->admission_date = $request->admission_date;

		$address->state = $request->state;
		$address->city = $request->city;
		$address->district = $request->district;
		$address->street = $request->street;
		$address->number = $request->number;
		$address->complement = $request->complement;
		$address->cep = $request->cep;
		
		$user->save();
		$address->save();

		return response()->json($user); // remove later
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->first();
		$user->delete();

		return response()->json($user); // remove later
    }
}
