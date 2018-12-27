<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
	protected $primaryKey = 'supplier_id';
    protected $fillable = [
    	'name', 'address', 'phone_number', 'city_id', 'user_id'
    ];
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function order(){
    	return $this->hasMany('App\Models\Order', 'supplier_id');
    }

    public function cities(){
    	return $this->belongsTo('App\Models\Cities', 'city_id');
    }
}
