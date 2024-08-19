<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequest;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::with('product:id,name', 'user:id,name')->get();

        return view('stock.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        $products = Product::all();

        return view('stock.create', compact('employees', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        Stock::create($data);

        return redirect()->route('stocks.index');
    }
}
