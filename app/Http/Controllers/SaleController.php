<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['employee', 'customer', 'saleItem.productItem.product', 'saleItem.appointmentItem.appointment'])->get();
        // return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		$customers = Customer::get();
        // return view('sales.create', ['customers' => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
		$data = $request->validated();

		$data['employee_id'] = Auth::user()->employee->id;
		
		DB::beginTransaction();

        $sale = Sale::create([
            'employee_id' => $data['employee_id'],
            'customer_id' => $data['customer_id'],
        ]);

        foreach ($data['sale_items'] as $itemData) {
            $saleItem = $sale->saleItem()->create([
                'price' => $itemData['price'],
            ]);

            if ($itemData['type'] === 'product') {
                $saleItem->productItem()->create([
                    'product_id' => $itemData['product_item']['product_id'],
                    'quantity' => $itemData['product_item']['quantity'],
                ]);
            } elseif ($itemData['type'] === 'appointment') {
                $saleItem->appointmentItem()->create([
                    'appointment_id' => $itemData['appointment_item']['appointment_id'],
                ]);
            }
        }

        DB::commit();

        // return redirect()->route('sale.index')->with('success', 'Venda adicionada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        // return view('sales.show', ['sale' => $sale]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
		$customers = Customer::get();

        // return view('sales.edit', [
		// 	'sale' => $sale,
		// 	'customers' => $customers,
		// ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale)
    {
		$data = $request->validated();

        DB::beginTransaction();

        if (isset($data['customer_id'])) {
            $sale->customer_id = $data['customer_id'];
        }

        $sale->save();

        if (isset($data['sale_items'])) {
            foreach ($data['sale_items'] as $itemData) {
                if (isset($itemData['id'])) {
                    $saleItem = SaleItem::find($itemData['id']);

                    if ($saleItem) {
                        $saleItem->update([
                            'price' => $itemData['price'],
                        ]);
                        if ($itemData['type'] === 'product') {
                            $saleItem->productItem()->updateOrCreate(
                                [],
                                [
                                    'product_id' => $itemData['product_item']['product_id'],
                                    'quantity' => $itemData['product_item']['quantity'],
                                ]
                            );
                            $saleItem->appointmentItem()->delete();
                        } elseif ($itemData['type'] === 'appointment') {
                            $saleItem->appointmentItem()->updateOrCreate(
                                [],
                                [
                                    'appointment_id' => $itemData['appointment_item']['appointment_id'],
                                ]
                            );
                            $saleItem->productItem()->delete();
                        }
                    }
                } else {
                    $newSaleItem = $sale->saleItem()->create([
                        'price' => $itemData['price'],
                    ]);

                    if ($itemData['type'] === 'product') {
                        $newSaleItem->productItem()->create([
                            'product_id' => $itemData['product_item']['product_id'],
                            'quantity' => $itemData['product_item']['quantity'],
                        ]);
                    } elseif ($itemData['type'] === 'appointment') {
                        $newSaleItem->appointmentItem()->create([
                            'appointment_id' => $itemData['appointment_item']['appointment_id'],
                        ]);
                    }
                }
            }
        }

        DB::commit();

        // return redirect()->route('products.index')->with('success', 'Venda atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        Sale::find($sale->id)->delete();
        // return redirect()->route('sales.index')->with('success', 'Venda removida com sucesso.');
    }
}
