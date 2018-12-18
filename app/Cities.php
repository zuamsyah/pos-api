<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{	
    public $timestamps = false;
    
    protected $fillable = [
      'name'
    ];

    // public function supplier(){
    // 	return $this->hasMany('App\Models\Supplier', 'city_id');
    // }
}

