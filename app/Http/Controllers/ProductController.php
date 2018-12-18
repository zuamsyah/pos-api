<?php 

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use App\Transformers\ProductTransformer;
use App\Transformers\MutationTransformer;
use App\Product;

class ProductController extends Controller
{
	protected $fractal;

	private $productTransformer;

	private $mutationTransformer;

	public function __construct(Manager $fractal, ProductTransformer $productTransformer, MutationTransformer $mutationTransformer)
	{
		$this->fractal = $fractal;
		$this->productTransformer = $productTransformer;
		$this->mutationTransformer = $mutationTransformer;
	}

	public function index()
	{
		$products = Auth::user()->product()->orderBy('created_at', 'DESC')->paginate(5);
     
      	return $this->respondWithCollection($products, $this->productTransformer);
	}

	public function searchDataProduct(Request $request)
	{
		$data = ucfirst($request->get('product'));
		$product = Product::where('product_name', 'like', "%{$data}%")->get();
	
		if ($data) {
			return response()->json(['data' => $product],200);
		} else {
			return response()->json(['message' => 'please input the product name'],404);
		}
	}

	public function getStockReport()
	{
		$stock_product = Auth::user()->Product()->paginate(5);

		return $this->respondWithCollection($stock_product, $this->productTransformer);
	}

	public function getMutationReport()
	{
		$mutation_product = Product::paginate(5);

		return $this->respondWithCollection($mutation_product, $this->mutationTransformer);
	}

	public function show($id)
	{
		$product = Product::find($id);

		if (!$product) {
			return $this->sendError('Could not found the product');
		}
		return $this->respondWithItem($product, $this->productTransformer);
	}

	public function store(Request $request)
	{
		$input = $request->all();
		$user = Auth::user();
		$validator = Validator::make($input,[
			'product_code' => 'required|unique:products|max:20',
			'product_name' => 'required|unique:products',
			'category_id' => 'required|exists:categories,category_id',
			'buy_price' => 'required',
			'sell_price' => 'required',
			'unit' => 'required|string',
		]);

		if ($validator->fails()) {
			return response()->json([
				'message' => 'Could not create new product',
				'errors' => $validator->errors(),
				'status_code' => 400
			], 400);
		}
		$input['stock'] = 0;
		$product = $user->product()->create($input);
		if($product){
            return $this->sendData($product->toArray(), 'The resource is created successfully');
		} else {
			return $this->sendCustomResponse(500, 'Internal Error');
		}
	}

	public function update(Request $request, $id)
    {
      $input = $request->all();
      $product = Product::find($id);

      if (is_null($product)) {
        return $this->sendError("Product with id {$id} doesn't exist");
      } 

      $this->validate($request, [
        'product_name' => '',
        'category_id' => 'integer',
        'buy_price' => 'integer',
        'sell_price' => 'integer',
        'unit' => 'string',
      ]);

      $product->product_name = $input['product_name'];
      $product->category_id = $input['category_id'];
      $product->buy_price = $input['buy_price'];
      $product->sell_price = $input['sell_price'];
      $product->unit = $input['unit'];

      if ($product->save()) {
        return $this->sendResponse($product->toArray(), 'Product updated successfully.');
      }
	}
	
    public function destroy($id)
    {
      $product = Product::find($id);
      if (!$product) {
        return $this->sendError('Product not found');
      }

      if ($product->delete()) {
        return $this->sendCustomResponse(204, 'Product: ' . $product->product_name . ' deleted');
      }
    }
}
