<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $primaryKey = 'category_id';

    public $timestamps = false;

    protected $fillable = [
    	'category_name', 'user_id'
    ];

    public function product(){
        return $this->hasMany('App\Models\Product', 'category_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
