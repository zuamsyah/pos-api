<?php

namespace App\Transformers;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'categories'
    ];

    public function transform(Product $product)
    {
        return [
            'product_code' => $product->product_code,
            'product_name' => $product->product_name,
            'total_stock' => $product->total_stock,
            'buy_price' => $product->buy_price,
            'sell_price' => $product->sell_price,
            'unit' => $product->unit,
            'created_at' => (string) $product->created_at,
            'updated_at' => (string) $product->updated_at,
        ];
    }

    public function includeCategories(Product $product)
    {
        $products = $product->categories;
        
        return $this->item($products, new CategoriesTransformer);
    }
}