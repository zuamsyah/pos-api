<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use Carbon\Carbon;

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

    public function getDayOrderReport(Request $request)
    {
        $date = $request->get('date');
        $now = Carbon::now()->toDateString();
        $today = OrderDetail::whereDate('created_at', '=', $now)->paginate(10);
        $order_report = OrderDetail::whereDate('created_at', '=', $date)->paginate(10);
     
        if ($date) {
            return $this->respondWithCollection($order_report, $this->getOrderTransformer);
        } else {
            return $this->respondWithCollection($today, $this->getOrderTransformer);
        }
    }

    public function getMonthOrderReport(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');
        $month_now = Carbon::now()->format('m');
        $year_now = Carbon::now()->format('Y');
        $today = OrderDetail::whereMonth('created_at', '=', $month_now)->whereYear('created_at', '=', $year_now)->paginate(10);
        $order_report = OrderDetail::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->paginate(10);

        if ($month) {
            if ($year) {
                return $this->respondWithCollection($order_report, $this->getOrderTransformer);
            }
        } else {
            return $this->respondWithCollection($today, $this->getOrderTransformer);
        }
    }

    public function getDaySalesReport(Request $request)
    {
        $date = $request->get('date');
        $now = Carbon::now()->toDateString();
        $today = SalesDetail::whereDate('created_at', '=', $now)->paginate(10);
        $sales_report = SalesDetail::whereDate('created_at', '=', $date)->paginate(10);
     
        if ($date) {
            return $this->respondWithCollection($sales_report, $this->getSalesTransformer);
        } else {
            return $this->respondWithCollection($today, $this->getSalesTransformer);
        }
    }

    public function getMonthSalesReport(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');
        $month_now = Carbon::now()->format('m');
        $year_now = Carbon::now()->format('Y');
        $today = SalesDetail::whereMonth('created_at', '=', $month_now)->whereYear('created_at', '=', $year_now)->paginate(10);
        $sales_report = SalesDetail::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->paginate(10);

        if ($month) {
            if ($year) {
                return $this->respondWithCollection($sales_report, $this->getSalesTransformer);
            }
        } else {
            return $this->respondWithCollection($today, $this->getSalesTransformer);
        }
    }

    public function getStockReport(Request $request)
    {
        $date = $request->get('date');
        $now = Carbon::now()->toDateString();
        $today = Auth::user()->Product()->whereDate('created_at', '=', $now)->paginate(10);
        $stock_report = Auth::user()->Product()->whereDate('created_at', '=', $date)->paginate(10);
     
        if ($date) {
            return $this->respondWithCollection($stock_report, $this->stockProductTransformer);
        } else {
            return $this->respondWithCollection($today, $this->stockProductTransformer);
        }
    }

    public function getDayStockReport(Request $request)
    {
        $date = $request->get('date');
        $now = Carbon::now()->toDateString();
        $today = Auth::user()->Product()->whereDate('created_at', '=', $now)->paginate(10);
        $stock_report = Auth::user()->Product()->whereDate('created_at', '=', $date)->paginate(10);
     
        if ($date) {
            return $this->respondWithCollection($stock_report, $this->stockProductTransformer);
        } else {
            return $this->respondWithCollection($today, $this->stockProductTransformer);
        }
    }

    public function getMonthStockReport(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');
        $month_now = Carbon::now()->format('m');
        $year_now = Carbon::now()->format('Y');
        $today = Auth::user()->Product()->whereMonth('created_at', '=', $month_now)->whereYear('created_at', '=', $year_now)->paginate(10);
        $stock_report = Auth::user()->Product()->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->paginate(10);

        if ($month) {
            if ($year) {
                return $this->respondWithCollection($stock_report, $this->stockProductTransformer);
            }
        } else {
            return $this->respondWithCollection($today, $this->stockProductTransformer);
        }
    }

    public function getDayMutationReport(Request $request)
    {
        $date = $request->get('date');
        $now = Carbon::now()->toDateString();
        $today = Product::whereDate('created_at', '=', $now)->paginate(10);
        $mutation_report = Product::whereDate('created_at', '=', $date)->paginate(10);
     
        if ($date) {
            return $this->respondWithCollection($mutation_report, $this->mutationTransformer);
        } else {
            return $this->respondWithCollection($today, $this->mutationTransformer);
        }
    }

    public function getMonthMutationReport(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');
        $month_now = Carbon::now()->format('m');
        $year_now = Carbon::now()->format('Y');
        $today = Product::whereMonth('created_at', '=', $month_now)->whereYear('created_at', '=', $year_now)->paginate(10);
        $mutation_report = Product::whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->paginate(10);

        if ($month) {
            if ($year) {
                return $this->respondWithCollection($mutation_report, $this->mutationTransformer);
            }
        } else {
            return $this->respondWithCollection($today, $this->mutationTransformer);
        }
    }
}