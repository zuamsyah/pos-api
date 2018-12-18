<?php

namespace App\Transformers;

use App\Supplier;
use League\Fractal\TransformerAbstract;

class SupplierTransformer extends TransformerAbstract
{	
    public function transform(Supplier $supplier)
    {
        return [
        	'supplier_id' => $supplier->supplier_id,
            'city' => $supplier->cities,
            'name' => $supplier->name,
            'address' => $supplier->address,
            'phone_number' => $supplier->phone_number,
            'created_at' => (string) $supplier->created_at,
            'updated_at' => (string) $supplier->updated_at
        ];
    }
}