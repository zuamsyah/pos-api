<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $primaryKey = 'order_id';
	protected $fillable = [
		'product_code', 'total_price', 'user_id', 'supplier_id'
	];

    public function supplier(){
    	return $this->belongsTo('App\Supplier', 'supplier_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function orderdetail(){
        return $this->hasMany('App\OrderDetail','order_id', 'order_id');
    }
}
