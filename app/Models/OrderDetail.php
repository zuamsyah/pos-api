<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
    	'order_id', 'product_code', 'product_amount', 'buy_price', 'subtotal_price'
    ];

    public function order(){
    	return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_code');
    }
}
