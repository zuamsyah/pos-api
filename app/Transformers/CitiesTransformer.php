<?php

namespace App\Transformers;

use App\Models\Cities;
use League\Fractal\TransformerAbstract;

class CitiesTransformer extends TransformerAbstract
{	

    public function transform(Cities $cities)
    {
        return [
            'id' => $cities->id,
            'name' => $cities->name,
        ];
    }
}