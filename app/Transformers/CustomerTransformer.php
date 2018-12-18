<?php

namespace App\Transformers;

use App\Customer;
use League\Fractal\TransformerAbstract;

class CustomerTransformer extends TransformerAbstract
{	
    public function transform(Customer $customer)
    {
        return [
        	'customer_id' => $customer->customer_id,
            'city' => $customer->cities,
            'name' => $customer->name,
            'address' => $customer->address,
            'phone_number' => $customer->phone_number,
            'created_at' => (string) $customer->created_at,
            'updated_at' => (string) $customer->updated_at
        ];
    }
}