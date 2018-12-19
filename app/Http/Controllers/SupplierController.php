<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\SupplierTransformer;
use App\Supplier;

class SupplierController extends Controller
{
    protected $fractal;

    private $supplierTransformer;

    public function __construct(Manager $fractal, SupplierTransformer $supplierTransformer)
    {
      $this->fractal = $fractal;
      $this->supplierTransformer = $supplierTransformer;
    }

    public function index()
    {   
  	  $suppliers = Supplier::paginate(5);

      return $this->respondWithCollection($suppliers, $this->supplierTransformer);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'name' => 'required|unique:suppliers',
            'address' => 'required',
            'phone_number' => 'required|max:13',
            'city_id'=> 'required|exists:cities,id'
        ]);
        if ($validator->fails()) {
          return response()->json([
            'message' => 'Could not create new Supplier',
            'errors' => $validator->errors(),
            'status_code' => 400
          ], 400);
        }
        $supplier = Supplier::create($input);
        if($supplier){
            return $this->sendData($supplier->toArray(), 'The resource is created successfully');
          }else{
          return $this->sendCustomResponse(500, 'Internal Error');
        }
    }

    public function update(Request $request, $id)
    {
      $input = $request->all();
      $supplier = Supplier::find($id);

      if (is_null($supplier)) {
        return $this->sendError('Supplier not found');
      }

      $supplier->name = $input['name'];
      $supplier->address = $input['address'];
      $supplier->phone_number = $input['phone_number'];
      $supplier->city_id = $input['city_id'];

      if ($supplier->save()) {
        return $this->sendResponse($supplier->toArray(), 'Customer updated successfully.');
      }
    }

    public function destroy(Request $request, $id)
    {
      $supplier = Supplier::find($id);

      if (!$supplier) {
        return $this->sendError('Supplier not found');
      }
      if ($supplier->delete()) {
        return $this->sendCustomResponse(204, 'Supplier: ' . $supplier->name . ' Telah Dihapus');
      }
    }
}
