<?php

namespace App\Transformers;

use App\Order;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{	
	// protected $defaultIncludes = [
	// 	'user'
	// ];

    public function transform(Order $order)
    {
        return [
        	'order_id' => $order->order_id,
            'supplier' => $order->supplier,
            'user' => $order->user,
            'total_price' => $order->total_price,
            'created_at' => (string) $order->created_at,
            'updated_at' => (string) $order->updated_at,
        ];
    }

    // public function includeUser(Order $order)
    // {
    // 	$user = $order->user;
    // 	return $this->item($user, new UserTransformer);
    // }
}