<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\SupplierTransformer;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * @var fractal
     */
    protected $fractal;

    /**
     * @var supplierTransformer
     */
    private $supplierTransformer;

    /**
     * Construct Manager & Transformer instance
     * @param Manager             $fractal            
     * @param SupplierTransformer $supplierTransformer
     */
    public function __construct(Manager $fractal, SupplierTransformer $supplierTransformer)
    {
      $this->fractal = $fractal;
      $this->supplierTransformer = $supplierTransformer;
    }

    public function index(Request $request)
    {   
  	  $suppliers = Auth::user()->supplier()->paginate(10);
      $suppliers->setPath(url() . '/' . $request->path());       

      return $this->respondWithCollection($suppliers, $this->supplierTransformer);
    }

    public function show($id)
    {   
      $suppliers = Auth::user()->supplier()->find($id);
      
      if (!$suppliers) {
         return $this->sendError('Could not find Supplier');
      }

      return $this->respondWithItem($suppliers, $this->supplierTransformer);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|unique:suppliers,name,null,supplier_id,user_id,'.Auth::id(),
            'address' => 'required',
            'phone_number' => 'required|max:13|unique:suppliers',
            'city_id'=> 'required|exists:cities,id'
        ]);
        
        $supplier = $user->supplier()->create($input);
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
        return $this->sendCustomResponse(200, 'Supplier: ' . $supplier->name . ' Telah Dihapus');
      }
    }
}
