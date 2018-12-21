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
use App\User;

class UserController extends Controller
{
	protected $fractal;

	private $userTransformer;

	public function __construct(Manager $fractal, UserTransformer $userTransformer)
	{
		$this->fractal = $fractal;
		$this->userTransformer = $userTransformer;
	}

	/**
	 * Profile of user auth
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function profile(Request $request)
    {
        $users = Auth::user();

        return response()->json(['data' => $users],200);
        // return $this->respondWithItem($users, $this->userTransformer);

    }
    
    /**
    * Update the specified resource
    * @param  Request $request [description]
    * @return [type]           [description]
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
  	 * @param  Request $request [description]
  	 * @return [type]           [description]
  	 */
 	public function uploadPhoto(Request $request)
  	{
    	$this->validate($request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
		]);

	    $file = $request->file('photo');
	    $filename = Auth::user()->username . $file->getClientOriginalName();

	    $test = $file->move(base_path('public/images'),$filename);
		
		DB::table('users')
	        ->where('id', Auth::user()->id)
	        ->update(['photo' => url('images/'.$filename)]);

	    return response()->json(['message' => 'photo uploaded', 'status_code' => 200],200);
  	}
}