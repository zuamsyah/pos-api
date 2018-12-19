<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $primaryKey = 'sales_id';
	protected $fillable = [
		'product_code', 'total_price', 'user_id', 'customer_id'
	];

    public function customer(){
    	return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function salesdetail(){
        return $this->hasMany('App\Salesdetail', 'sales_id', 'sales_id');
    }
}
