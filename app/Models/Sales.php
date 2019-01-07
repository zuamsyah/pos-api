<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $primaryKey = 'sales_id';
	protected $fillable = [
		'product_code', 'total_price', 'user_id', 'customer_id'
	];

    public function customer(){
    	return $this->belongsTo('App\Models\Customer', 'customer_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function salesdetail(){
        return $this->hasMany('App\Models\SalesDetail', 'sales_id', 'sales_id');
    }
}
