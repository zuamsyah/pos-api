<?php

namespace App\Transformers;

use App\OrderDetail;
use League\Fractal\TransformerAbstract;

class OrderDetailTransformer extends TransformerAbstract
{	
    public function transform(OrderDetail $orderdetail)
    {
        return [
        	'id' => $orderdetail->id,
            'order_id' => $orderdetail->order_id,
            'product_code' => $orderdetail->product_code,
            // 'product_name' => $orderdetail->product()->first()->name,
            // 'supplier_name' => $orderdetail->order->supplier()->first()->name,
            'product_amount' => $orderdetail->product_amount,
            'buy_price' => $orderdetail->buy_price,
            'subtotal_price' => $orderdetail->subtotal_price,
            'created_at' => (string) $orderdetail->created_at,
            'updated_at' => (string) $orderdetail->updated_at
        ];
    }
}