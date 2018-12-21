<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\OrderDetailTransformer;
use App\OrderDetail;

class OrderDetailController extends Controller
{
    protected $fractal;

    private $orderDetailTransformer;

    public function __construct(Manager $fractal, OrderDetailTransformer $orderDetailTransformer)
    {
        $this->fractal = $fractal;
        $this->orderDetailTransformer = $orderDetailTransformer;
    }

    public function getOrderReport()
    {
        $order_detail = OrderDetail::paginate(10);
        
        return $this->respondWithCollection($order_detail, $this->orderDetailTransformer);
    }
}