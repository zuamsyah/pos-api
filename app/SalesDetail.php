<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    protected $fillable = [
    	'sales_id', 'product_code', 'product_amount', 'sell_price', 'subtotal_price'
    ];

    public function order(){
    	return $this->belongsTo('App\Order', 'sales_id');
    }

    public function product(){
        return $this->belongsTo('App\Product', 'product_code', 'id');
    }
}
