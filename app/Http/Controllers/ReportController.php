<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\GetOrderTransformer;
use App\Transformers\GetSalesTransformer;
use App\Transformers\MutationTransformer;
use App\Transformers\StockProductTransformer;
use App\OrderDetail;
use App\SalesDetail;
use App\Product;

class ReportController extends Controller
{
    protected $fractal;

    private $getOrderTransformer, $getSalesTransformer, $mutationTransformer, $stockProductTransformer;

    public function __construct(Manager $fractal, GetOrderTransformer $getOrderTransformer, GetSalesTransformer $getSalesTransformer, MutationTransformer $mutationTransformer, StockProductTransformer $stockProductTransformer)
    {
        $this->fractal = $fractal;
        $this->getOrderTransformer = $getOrderTransformer;
        $this->getSalesTransformer = $getSalesTransformer;
        $this->mutationTransformer = $mutationTransformer;
        $this->stockProductTransformer = $stockProductTransformer;
    }

    public function getOrderReport()
    {
        $order_detail = OrderDetail::paginate(10);
        
        return $this->respondWithCollection($order_detail, $this->getOrderTransformer);
    }

    public function getSalesReport()
    {
        $sales_detail = SalesDetail::paginate(10);
        
        return $this->respondWithCollection($sales_detail, $this->getSalesTransformer);
    }

    public function getStockReport()
    {
        $stock_product = Auth::user()->Product()->paginate(10);

        return $this->respondWithCollection($stock_product, $this->stockProductTransformer);
    }

    public function getMutationReport()
    {
        $mutation_product = Product::paginate(10);

        return $this->respondWithCollection($mutation_product, $this->mutationTransformer);
    }
}