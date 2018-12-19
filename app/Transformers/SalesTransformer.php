<?php

namespace App\Transformers;

use App\Sales;
use League\Fractal\TransformerAbstract;

class SalesTransformer extends TransformerAbstract
{	
    public function transform(Sales $sales)
    {
        return [
        	'order_id' => $sales->order_id,
            'customer_id' => $sales->customer_id,
            'user_id' => $sales->user_id,
            'total_price' => $sales->total_price,
            'created_at' => (string) $sales->created_at,
            'updated_at' => (string) $sales->updated_at,
        ];
    }
}