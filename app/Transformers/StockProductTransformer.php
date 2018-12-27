<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class StockProductTransformer extends TransformerAbstract
{
    public function transform(Product $product)
    {
        return [
            'product_code' => $product->product_code,
            'product_name' => $product->product_name,
            'unit' => $product->unit,
            'buy_price' => $product->buy_price,
            'sell_price' => $product->sell_price,
            'total_stock' => $product->total_stock,
            'created_at' => (string) $product->created_at,
            'updated_at' => (string) $product->updated_at,
        ];
    }
}