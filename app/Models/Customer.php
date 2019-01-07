<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';

    protected $fillable = [
      'name', 'address', 'phone_number', 'city_id', 'user_id'
    ];

    public function user(){
      return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function cities(){
    	return $this->belongsTo('App\Models\Cities', 'city_id');
    }
}
