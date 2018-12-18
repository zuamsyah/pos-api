<?php

namespace App\Transformers;

use App\Categories;
use League\Fractal\TransformerAbstract;

class CategoriesTransformer extends TransformerAbstract
{	

    public function transform(Categories $category)
    {
        return [
            'category_id' => $category->category_id,
            'category_name' => $category->category_name,
        ];
    }
}