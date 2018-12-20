<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\SalesTransformer;
use App\Sales;
use App\Product;
use App\Customer;
use App\SalesDetail;

class SalesController extends Controller
{
    /**
     * @var fractal
     */
    protected $fractal;

    /**
     * @var salesTransformer
     */
    private $salesTransformer;

    public function __construct(Manager $fractal, SalesTransformer $salesTransformer)
    {
        $this->fractal = $fractal;
        $this->salesTransformer = $salesTransformer;
    }

    public function index()
    {
        $sales = Auth::user()->Sales()->orderBy('created_at', 'DESC')->paginate(5);
     
        return $this->respondWithCollection($sales, $this->salesTransformer);
    }

    public function store(Request $request)
    {
    	$input = $request->all();
    	$user = Auth::user();
    	$validator = Validator::make($input, [
    		'customer_id' => 'required|integer|exists:customers,customer_id'
    	]);

    	if ($validator->fails()) {
	        return response()->json([
	          'message' => 'Could not create new Sales',
	          'errors' => $validator->errors(),
	          'status_code' => 400
	        ], 400);
	    }

	    $sales = $user->sales()->create([
            'sales_id' => $request->sales_id,
            'customer_id' => $request->customer_id,
        ]);
    	if ($sales) {
            return $this->sendData($sales->toArray(), 'The resource is created successfully');
    	} else {
            return $this->sendCustomResponse(500, 'Internal Error');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_code' => 'required|exists:products,product_code',
            'product_amount' => 'required|integer'
        ]);
        
        try {
            $sales = Sales::find($id);
            $salesdetail = SalesDetail::find($id);
            if (is_null($sales)) {
                return $this->sendError("Sales with id {$id} doesn't exist");
            } 
            //select berdasarkan table product berdasar product code
            $product = Product::find($request->product_code);
            //select dari table sales_details berdasar product_code & sales_id
            $sales_details = $sales->salesdetail()->where('product_code', $product->product_code);
            $sales_detail = $sales_details->first();
            if ($sales_detail) {
                $sales_detail->update([
                    //jika data ada diupdate data product amount
                    'product_amount' => $sales_detail->product_amount + $request->product_amount,
                    // 'subtotal_price' => $sales_detail->product_amount * $product->sell_price
                ]);
            } else {
                $sales_detail = SalesDetail::create([
                    'sales_id' => $sales->sales_id,
                    'product_code' => $request->product_code,
                    'product_amount' => $request->product_amount,
                    'sell_price' => $product->sell_price,
                    'subtotal_price' => $request->product_amount * $product->sell_price
                ]);
            }
            
            $sales_id = $sales_details->where('sales_id', $id)->first();
            $product_code = DB::table('sales_details')
                ->where('product_code', $product->product_code)
                ->get()->all();


            $stock = $product->stock;
            // dd($stock);
            foreach ($product_code as $product) {
                $stock -= $product->product_amount;
            }

            DB::table('sales_details')
                ->where('sales_id', $id)
                ->where('product_code', $request->product_code)
                ->update([
                    'subtotal_price' => $sales_id->product_amount * $product->sell_price,
                ]);

            DB::table('products')
                ->where('product_code', $request->product_code)
                ->update([
                'stock' => $stock
            ]);
            $total_price = DB::table('sales_details')
                ->where('sales_id', $id)
                ->get()->all();
                
            $price = 0;
            foreach ($total_price as $sales) {
                $price += $sales->subtotal_price;
            }

            DB::table('sales')
                ->where('sales_id', $id)
                ->update([
                    'total_price' => $price
                ]);

            $data = [
                'sales_id' => $sales->sales_id,
                'product_code' => $request->product_code,
                'product_amount' => $sales_detail->product_amount,
                'sell_price' => $product->sell_price,
                'subtotal_price' => $sales_id->product_amount * $product->sell_price
            ];

            return $this->sendResponse($data, 'Sales updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
