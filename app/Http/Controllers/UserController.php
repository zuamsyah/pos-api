<?php 

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use App\Transformers\UserTransformer;
use App\Models\User;

class UserController extends Controller
{
	/**
	 * @var fractal
	 */
	protected $fractal;

	/**
	 * @var userTransformer
	 */
	private $userTransformer;

	/**
	 * Construct Manager & Transformer instance
	 * @param Manager         $fractal        
	 * @param UserTransformer $userTransformer
	 */
	public function __construct(Manager $fractal, UserTransformer $userTransformer)
	{
		$this->fractal = $fractal;
		$this->userTransformer = $userTransformer;
	}

	/**
	 * Profile of user auth
	 * @param  Request $request
	 * @return respondWithItem
	 */
	public function profile(Request $request)
    {
        $users = Auth::user();

		if(!$users){
			return response()->json(['success' => false, 'message' => 'User Not found'],404);
		}
        return $this->respondWithItem($users, $this->userTransformer);
    }
    
    /**
    * Update the specified resource
    * @param  Request $request
    * @return sendResponse
    */
    public function update(Request $request)
    {
		$input = $request->all();
		$this->validate($request, [
			'name' => 'string|min:3|max:30',
			'username' => 'min:3|max:10',
			'address' => '',
			'phone_number' => 'max:13'
	    ]);

	    $account = Auth::user();

	    $input['updated_at'] = \Carbon\Carbon::now('Asia/Jakarta');
	    
	    if ($account->update($input)) {
	    	
	        return $this->sendResponse($account->toArray(), 'Profile updated successfully.');
	    }
  	}

  	/**
  	 * Upload user profile
  	 * @param  Request $request
  	 * @return \Illuminate\Http\JsonResponse          
  	 */
 	public function uploadPhoto(Request $request)
  	{
    	$this->validate($request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
		]);

	    $file = $request->file('photo');
	    if ($file) {
		    $filename = Auth::user()->username . date('Ymd') .'.'. $file->getClientOriginalExtension();

		    $file->move('images',$filename);
			
			DB::table('users')
		        ->where('id', Auth::user()->id)
		        ->update(['photo' => url('images/'.$filename)]);

		    return response()->json(['message' => 'photo uploaded', 'status_code' => 200],200);
	    } else { 	
		    return response()->json(['message' => 'Internal Error', 'status_code' => 500],500);
	    }
	    
  	}
}