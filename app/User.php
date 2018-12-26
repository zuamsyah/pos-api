<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'photo', 'address', 'phone_number'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($password)
    {
       $this->attributes['password'] = Hash::make($password);
    }

    public function categories(){
      return $this->hasMany('App\Categories', 'user_id');
    }

    public function customer(){
      return $this->hasMany('App\Customer', 'user_id');
    }

    public function supplier(){
      return $this->hasMany('App\Supplier', 'user_id');
    }

    public function order(){
      return $this->hasMany('App\Order', 'user_id');
    }

    public function sales(){
      return $this->hasMany('App\Sales', 'user_id');
    }

    public function product(){
      return $this->hasMany('App\Product', 'user_id');
    }
}
