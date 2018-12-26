<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\CategoriesTransformer;
use App\Categories;

class CategoriesController extends Controller
{
    /**
     * @var fractal
     */
    protected $fractal;
    /**
     * @var categoriesTransformer
     */
    private $categoriesTransformer;

    function __construct(Manager $fractal, CategoriesTransformer $categoriesTransformer)
    {
        $this->fractal = $fractal;
        $this->categoriesTransformer = $categoriesTransformer;
    }

    public function index()
    {
        $category = Auth::user()->categories()->paginate(10);

        return $this->respondWithCollection($category, $this->categoriesTransformer);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [  
           'category_name' => 'required|max:50|unique:categories'
        ]);

        $category = Categories::create($input);
        if($category){
            return $this->sendData($category->toArray(), 'The resource is created successfully');
        }else{
            return $this->sendCustomResponse(500, 'Internal Error');
        }
    }

    public function destroy($id)
    {
        $categories = Categories::find($id);
        if (!$categories){
          return $this->sendError('Category not found');
        }
        if ($categories->delete()) {
          return $this->sendCustomResponse(200, 'Category: ' . $categories->name . ' deleted');
        }
    }
}
