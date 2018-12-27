<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\SalesTransformer;
use App\Models\Sales;
use App\Models\Product;
use App\Models\SalesDetail;

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

    /**
     * Construct Manager & Transformer instance
     * @param Manager          $fractal         
     * @param SalesTransformer $salesTransformer
     */
    public function __construct(Manager $fractal, SalesTransformer $salesTransformer)
    {
        $this->fractal = $fractal;
        $this->salesTransformer = $salesTransformer;
    }

    public function index()
    {
        $sales = Auth::user()->Sales()->orderBy('created_at', 'DESC')->paginate(10);
     
        return $this->respondWithCollection($sales, $this->salesTransformer);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'customer_id' => 'required|integer|exists:customers,customer_id',
            'product_code' => 'required|exists:products,product_code'
    	]);

	    $save = Auth::user()->Sales()->create([
            'sales_id' => $request->sales_id,
            'customer_id' => $request->customer_id,
        ]);
        $total = 0;
            if ($save) {
                $id_sales = $save->sales_id;
                for ($i=0; $i < count($request->product_code); $i++) { 
                    $product = Product::find($request->product_code[$i]);
                    $product_stock = Product::find($request->product_code[$i])->total_stock;
                    $save1 = SalesDetail::create([
                        'sales_id' => $id_sales,
                        'product_code' => $request->product_code[$i],
                        'product_amount' => $request->product_amount[$i],
                        'sell_price' => $product->sell_price,
                        'subtotal_price' => $request->product_amount[$i] * $product->sell_price
                    ]);

                    $stockout = 0;
                    $amount = DB::table('sales_details')->where('product_code', $product->product_code)->get()->all();
                    
                    foreach ($amount as $stock) {
                        $stockout += $stock->product_amount;
                    }
                    
                    //hitung & kurang stock dari penjualan barang
                    DB::table('products')->where('product_code', $request->product_code[$i])->update([
                        'total_stock' => $product_stock - $request->product_amount[$i],
                        'stock_out' => $stockout
                    ]);
                    
                    $total += $save1->subtotal_price;
                    //hitung total harga
                    DB::table('sales')->where('sales_id', $id_sales)->update([
                        'total_price' => $total
                    ]);
                }
            }

        $data = DB::table('sales_details')->where('sales_id', $id_sales)->get();

        if ($save1) {
            return $this->sendData($data->toArray(), 'The resource is created successfully');
        } else {
            return $this->sendCustomResponse(500, 'Internal Error');
        }
    }

    
}
