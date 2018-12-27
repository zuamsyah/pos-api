<?php

namespace App\Transformers;

use App\Models\Supplier;
use League\Fractal\TransformerAbstract;

class SupplierTransformer extends TransformerAbstract
{	
    protected $defaultIncludes = [
        'cities'
    ];

    public function transform(Supplier $supplier)
    {
        return [
        	'supplier_id' => $supplier->supplier_id,
            'name' => $supplier->name,
            'address' => $supplier->address,
            'phone_number' => $supplier->phone_number,
            'created_at' => (string) $supplier->created_at,
            'updated_at' => (string) $supplier->updated_at
        ];
    }

    public function includeCities(Supplier $supplier)
    {
        $cities = $supplier->cities;

        return $this->item($cities, new CitiesTransformer);
    }
}