<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequest;
use App\Models\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::with(["product:id,name,price,quantity", "user:id,name"])->get();
        foreach ($stocks as $stock) {
            $total = $stock->product->price * $stock->quantity;
            echo "BY: {$stock->user?->name} | PRODUCT: {$stock->product->name} ({$stock->product->quantity}) | QUANTITY: {$stock->quantity} | TOTAL: {$total} <br>";
        }
        return;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        $data = $request->validated();
        Stock::create($data);

        return redirect()->route('stocks.index');
    }
}
