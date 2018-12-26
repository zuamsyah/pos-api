<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';

    protected $fillable = [
      'name', 'address', 'phone_number', 'city_id', 'user_id'
    ];

    public function user(){
      return $this->belongsTo('App\User', 'user_id');
    }

    public function cities(){
    	return $this->belongsTo('App\Cities', 'city_id');
    }
}
