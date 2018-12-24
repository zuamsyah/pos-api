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
            'first_stock' => $product->first_stock,
            'stock_in' => $product->stock_in,
            'stock_out' => $product->stock_out,
            'total_stock' => $product->total_stock,
            'first_balance' => $product->first_stock * $product->buy_price,
            'value_in' => $product->stock_in * $product->buy_price,
            'value_out' => $product->stock_out * $product->sell_price,
            'total_balance' => ($product->first_stock * $product->buy_price) + ($product->stock_in * $product->buy_price) - ($product->stock_out * $product->sell_price)
        ];
    }
}