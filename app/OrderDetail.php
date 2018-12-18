<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{	
    protected $fillable = [
    	'order_id', 'product_code', 'product_amount', 'buy_price', 'subtotal_price'
    ];

    public function order(){
    	return $this->belongsTo('App\Order', 'order_id');
    }

    public function product(){
        return $this->belongsTo('App\Product', 'product_code');
    }
}
