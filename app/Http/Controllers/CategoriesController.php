<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\CategoriesTransformer;
use App\Models\Categories;

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

    /**
     * Construct Manager & Transformer instance
     * @param Manager               $fractal              
     * @param CategoriesTransformer $categoriesTransformer
     */
    function __construct(Manager $fractal, CategoriesTransformer $categoriesTransformer)
    {
        $this->fractal = $fractal;
        $this->categoriesTransformer = $categoriesTransformer;
    }

    public function index(Request $request)
    {
        $category = Auth::user()->categories()->orderBy('category_id', 'ASC')->paginate(10);
		$category->setPath(url() . '/' . $request->path());
        return $this->respondWithCollection($category, $this->categoriesTransformer);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $this->validate($request, [  
           'category_name' => 'required|max:50|unique:categories,category_name,null,category_id,user_id,'.Auth::id(),
        ]);

        $category = $user->categories()->create($input);
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
