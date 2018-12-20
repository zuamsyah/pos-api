<?php 

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
	/**
	 * Profile of user auth
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function profile(Request $request)
    {
        $users = Auth::user(); // Get users from DB

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
	    $validator = Validator::make($input,[
	      'name' => 'string|min:3|max:30|unique:users',
	      'username' => 'min:3|max:10',
	      'address' => '',
	      'phone_number' => 'max:13'
	    ]);

	    if($validator->fails()) {
	        return response()->json([
	            'status' => 'error',
	            'message' => $validator->messages()
	        ]);
	    }

	    $account = Auth::user();

	    $input['updated_at'] = \Carbon\Carbon::now('Asia/Jakarta');
	    
	    if ($account->update($input)) {
	    	return response()->json(['data' => $account, 'message' => 'Profile updated successfully.'],200);
	        // return $this->sendResponse($account->toArray(), 'Profile updated successfully.');
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
	    $filename = Auth::user()->username . '.' . $file->getClientOriginalExtension();

	    $test = $file->move(base_path('public/images'),$filename);
	    // dd($test);
	    DB::table('users')
	        ->where('id', Auth::user()->id)
	        ->update(['photo' => url('images/'.$filename)]);

	    return response()->json(['message' => 'photo uploaded', 'status_code' => 200],200);
  	}
}