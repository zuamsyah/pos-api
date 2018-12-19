<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class MutationTransformer extends TransformerAbstract
{	
    public function transform(Product $product)
    {
        return [
            'product_code' => $product->product_code,
            'product_name' => $product->product_name,
            'unit' => $product->unit,
            'first_stock' => 0,
            'incoming_stock' => $product->first()->orderdetail->first()->product_amount,
            'stock_out' => 'penjualan',
            'incoming_value' => $product->first()->orderdetail->first()->subtotal_price,
            'value_out' => 'nilai keluar',
            'total_balance' => $product->first()->orderdetail->first()->order()->first()->total_price,
            'stock' => $product->stock,
            'buy_price' => $product->buy_price,
            'sell_price' => $product->sell_price,
        ];
    }
}