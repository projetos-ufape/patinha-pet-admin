<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Redirect;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {

        $data = $request->validated();

        Service::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
        ]);

        return Redirect::route('services.index')->with('success', 'Serviço cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {

        $data = $request->validated();

        $service->updateOrFail([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
        ]);

        return Redirect::route('services.index', [$service])->with('success', 'Serviço atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->deleteOrFail();

        return redirect()->route('services.index')->with('success', 'Serviço removido com sucesso.');
    }
}
