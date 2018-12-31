<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\OrderTransformer;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    /**
     * @var fractal
     */
    protected $fractal;

    /**
     * @var orderTransformer
     */
    private $orderTransformer;

    /**
     * Construct Manager & Transformer instance
     * @param Manager          $fractal         
     * @param OrderTransformer $orderTransformer
     */
    public function __construct(Manager $fractal, OrderTransformer $orderTransformer)
    {
        $this->fractal = $fractal;
        $this->orderTransformer = $orderTransformer;
    }

    public function index(Request $request)
    {
        $orders = Auth::user()->Order()->orderBy('created_at', 'DESC')->paginate(10);
		$orders->setPath(url() . '/' . $request->path());        
        return $this->respondWithCollection($orders, $this->orderTransformer);
    }

    public function show($id)
	{
        $query = Order::find($id);
		if (!$query) {
			return $this->sendError('Could not found the order');
        } else {
            $data = $query->orderdetail()->get();
            return response()->json(['data' => $data],200);   
        }
	}

    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'supplier_id' => 'required|integer|exists:suppliers,supplier_id',
            'product_code' => 'required|exists:products,product_code'
    	]);

        $save = Auth::user()->Order()->create([
            'order_id' => $request->order_id,
            'supplier_id' => $request->supplier_id,
        ]);
        $total = 0;
            if ($save) {
                $id_order = $save->order_id;     
                for ($i=0; $i < count($request->product_code); $i++) { 
                    $product = Product::find($request->product_code[$i]);
                    $product_stock = Product::find($request->product_code[$i])->total_stock;
                    $save1 = Auth::user()->orderdetail()->create([
                        'order_id' => $id_order,
                        'product_code' => $request->product_code[$i],
                        'product_amount' => $request->product_amount[$i],
                        'buy_price' => $product->buy_price,
                        'subtotal_price' => $request->product_amount[$i] * $product->buy_price
                    ]);

                    $stockin = 0;
                    $amount = DB::table('order_details')->where('product_code', $product->product_code)->get()->all(); 
                    
                    foreach ($amount as $stock) {
                        $stockin += $stock->product_amount;
                    }

                    //hitung & tambah stock dari pembelian barang
                    DB::table('products')->where('product_code', $request->product_code[$i])->update([
                        'total_stock' => $product_stock + $request->product_amount[$i],
                        'stock_in' => $stockin
                    ]);
                    
                    $total += $save1->subtotal_price;
                    //hitung total harga
                    DB::table('orders')->where('order_id', $id_order)->update([
                        'total_price' => $total
                    ]);
                    
                }
            }


        $data = DB::table('order_details')->where('order_id', $id_order)->get();

        if ($save1) {
            return $this->sendData($data->toArray(), 'The resource is created successfully');
        } else {
            return $this->sendCustomResponse(500, 'Internal Error');
        }

    }
}
