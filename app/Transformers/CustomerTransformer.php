<?php

namespace App\Transformers;

use App\Models\Customer;
use League\Fractal\TransformerAbstract;

class CustomerTransformer extends TransformerAbstract
{	
    protected $defaultIncludes = [
        'cities'
    ];

    public function transform(Customer $customer)
    {
        return [
        	'customer_id' => $customer->customer_id,
            'name' => $customer->name,
            'address' => $customer->address,
            'phone_number' => $customer->phone_number,
            'created_at' => (string) $customer->created_at,
            'updated_at' => (string) $customer->updated_at
        ];
    }

    public function includeCities(Customer $customer)
    {
        $cities = $customer->cities;

        return $this->item($cities, new CitiesTransformer);
    }
}