<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class StoreSaleAction
{
    const TYPE_PRODUCT = 'product';

    const TYPE_APPOINTMENT = 'appointment';

    public static function execute(array $data)
    {
        try {
            DB::beginTransaction();

            $sale = Sale::create([
                'employee_id' => $data['employee_id'],
                'customer_id' => $data['customer_id'],
            ]);

            foreach ($data['sale_items'] as $itemData) {
                self::createSaleItem($sale, $itemData);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Erro ao registrar venda: '.$e->getMessage());
        }
    }

    private static function createSaleItem($sale, $itemData)
    {
        $saleItem = $sale->saleItem()->create([
            'price' => $itemData['price'],
        ]);

        if ($itemData['type'] === self::TYPE_PRODUCT) {
            self::createProductSaleItem($saleItem, $itemData['product_item']);
        } elseif ($itemData['type'] === self::TYPE_APPOINTMENT) {
            self::createAppointmentSaleItem($saleItem, $itemData['appointment_item']);
        }
    }

    private static function createProductSaleItem($saleItem, $productItem)
    {
        $product = Product::find($productItem['product_id']);
        if (! $product) {
            throw new \Exception('Produto não encontrado.');
        }

        if ($product->quantity < $productItem['quantity']) {
            throw new \Exception('Estoque insuficiente para o produto: '.$product->name);
        }

        $saleItem->productItem()->create([
            'product_id' => $productItem['product_id'],
            'quantity' => $productItem['quantity'],
        ]);

        $product->quantity -= $productItem['quantity'];
        $product->save();
    }

    private static function createAppointmentSaleItem($saleItem, $appointmentItem)
    {
        $saleItem->appointmentItem()->create([
            'appointment_id' => $appointmentItem['appointment_id'],
        ]);
    }
}
