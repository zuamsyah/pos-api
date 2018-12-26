<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
	protected $primaryKey = 'supplier_id';
    protected $fillable = [
    	'name', 'address', 'phone_number', 'city_id', 'user_id'
    ];
    
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function order(){
    	return $this->hasMany('App\Order', 'supplier_id');
    }

    public function cities(){
    	return $this->belongsTo('App\Cities', 'city_id');
    }
}
