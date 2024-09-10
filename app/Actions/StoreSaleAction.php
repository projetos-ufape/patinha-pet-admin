<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class StoreSaleAction
{
    /*
    * Store a sale.
    *
    * @param array $data
    * @return \Illuminate\Http\RedirectResponse
    */
    public static function execute(array $data)
    {
        try {
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

                    $product = Product::find($itemData['product_item']['product_id']);
                    if (! $product) {
                        throw new \Exception('Produto não encontrado.');
                    }

                    if ($product->quantity < $itemData['product_item']['quantity']) {
                        throw new \Exception('Estoque insuficiente para o produto: '.$product->name);
                    }

                    $saleItem->productItem()->create([
                        'product_id' => $itemData['product_item']['product_id'],
                        'quantity' => $itemData['product_item']['quantity'],
                    ]);

                    $product->quantity -= $itemData['product_item']['quantity'];
                    $product->save();
                } elseif ($itemData['type'] === 'appointment') {
                    $saleItem->appointmentItem()->create([
                        'appointment_id' => $itemData['appointment_item']['appointment_id'],
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Erro ao registrar venda: '.$e->getMessage());
        }
    }
}
