<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'address' => $user->address,
            'phone_number' => $user->phone_number,
            'photo' => $user->photo,
            'created_at' => (string) $user->created_at,
            'updated_at' => (string) $user->updated_at
        ];
    }
}