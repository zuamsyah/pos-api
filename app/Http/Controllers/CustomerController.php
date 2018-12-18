<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\CustomerTransformer;
use App\Customer;

class CustomerController extends Controller
{
    /**
     * @var fractal
     */
    protected $fractal;
    /**
     * @var customerTransformer
     */
    private $customerTransformer;

    public function __construct(Manager $fractal, CustomerTransformer $customerTransformer)
    {
        $this->fractal = $fractal;
        $this->customerTransformer = $customerTransformer;
    }

    public function index()
    {
      $customers = Customer::paginate(5);
     
      return $this->respondWithCollection($customers, $this->customerTransformer);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'name' => 'required|string|unique:customers',
            'address' => 'required',
            'phone_number' => 'required|max:13|unique:customers',
            'city_id'=> 'required|exists:cities,id'
        ]);
        if ($validator->fails()) {
          return response()->json([
            'message' => 'Could not create new Customer',
            'errors' => $validator->errors(),
            'status_code' => 400
          ], 400);
        }
        $customer = Customer::create($input);
        if($customer){
            return $this->sendData($customer->toArray(), 'The resource is created successfully');
          }else{
          return $this->sendCustomResponse(500, 'Internal Error');
        }
    }

    public function update(Request $request, $id)
    {
      $input = $request->all();
      $customer = Customer::find($id);

      if (is_null($customer)) {
        return $this->sendError('Customer not found');
      }

      $customer->name = $input['name'];
      $customer->address = $input['address'];
      $customer->phone_number = $input['phone_number'];
      $customer->city_id = $input['city_id'];

      if ($customer->save()) {
        return $this->sendResponse($customer->toArray(), 'Customer updated successfully.');
      }
    }

    public function destroy(Request $request, $id)
    {
      $customer = Customer::find($id);

      if (!$customer) {
        return $this->sendError('Customer not found');
      }
      if ($customer->delete()) {
        return $this->sendCustomResponse(204, 'Customer: ' . $customer->name . ' deleted');
      }
    }
}
