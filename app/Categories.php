<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $primaryKey = 'category_id';

    public $timestamps = false;

    protected $fillable = [
    	'category_name'
    ];

    public function product(){
        return $this->hasMany('App\Product', 'category_id');
    }
}
