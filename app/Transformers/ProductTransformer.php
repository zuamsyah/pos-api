<?php

namespace App\Transformers;

use App\s;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Prodsuct $product)
    {
        return [
            'product_code' => $product->product_code,
            'product_name' => $product->product_name,
            'categories' => $product->categories,
            'stock' => $product->stock,
            'buy_price' => $product->buy_price,
            'sell_price' => $product->sell_price,
            'unit' => $product->unit,
            'created_at' => (string) $product->created_at,
            'updated_at' => (string) $product->updated_at,
        ];
    }
}