<?php

namespace App\Transformers;

use App\SalesDetail;
use League\Fractal\TransformerAbstract;

class GetSalesTransformer extends TransformerAbstract
{	
    public function transform(SalesDetail $salesdetail)
    {
        return [
        	'id' => $salesdetail->id,
            'order_id' => $salesdetail->order_id,
            'product_code' => $salesdetail->product_code,
            'product_name' => $salesdetail->product()->get()->first()->product_name,
            'customer_name' => $salesdetail->order->supplier()->get()->first()->name,
            'product_amount' => $salesdetail->product_amount,
            'sell_price' => $salesdetail->sell_price,
            'subtotal_price' => $salesdetail->subtotal_price,
            'created_at' => (string) $salesdetail->created_at,
            'updated_at' => (string) $salesdetail->updated_at
        ];
    }
}