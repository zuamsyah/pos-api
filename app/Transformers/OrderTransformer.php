<?php

namespace App\Transformers;

use App\Models\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(Order $order)
    {
        return [
        	'order_id' => $order->order_id,
            'supplier_id' => $order->supplier_id,
            'supplier_name' => $order->supplier->name,
            'user_id' => $order->user_id,
            'user_name' => $order->user->username,
            'total_price' => $order->total_price,
            'created_at' => (string) $order->created_at,
            'updated_at' => (string) $order->updated_at,
        ];
    }
}