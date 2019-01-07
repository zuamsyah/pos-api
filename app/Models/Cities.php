<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{	
    public $timestamps = false;
    
    protected $fillable = [
      'name'
    ];
}

