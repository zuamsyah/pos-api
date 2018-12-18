<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use JWTAuthException;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    $credentials = $request->only('username', 'password');
    $rules = [
        'username' => 'required|max:10',
        'password' => 'required|min:6',
    ];
    $validator = Validator::make($credentials, $rules);
    if($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->messages()
        ]);
    }

    try {
        // Attempt to verify the credentials and create a token for the user
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'We can`t find an account with this credentials.'
            ], 401);
        }
    } catch (JWTException $e) {
        // Something went wrong with JWT Auth.
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to login, please try again.'
        ], 500);
    }
    // All good so return the token
    return response()->json([
        'status' => 'success',
        'user' => $request->username,
        'token_type' => 'Bearer',
        'data'=> [
            'token' => $token
            // You can add more details here as per you requirment.
        ],
    ]);
  }
  public function register(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($input, [
          'username' => 'required|alpha_dash|min:3|max:10|unique:users',
          'email' => 'required|email|min:5|max:255|unique:users',
          'password'=> 'required|min:6'
        ]);

    if ($validator->fails()) {
        return response()->json($validator->errors());
    }

    $user = User::create([
          'username' => $request->get('username'),
          'email' => $request->get('email'),
          'password' => $request->get('password'),
          'photo' => url('images/avatar-df.jpg')
    ]);
    $token = JWTAuth::fromUser($user);

    return response()->json([
      'user' => $user,
      'success' => true,
      'token' => $token
    ],201);
  }

  public function logout(Request $request)
  {
    // Get JWT Token from the request header key "Authorization"
    $token = $request->header('Authorization');
    // Invalidate the token
    try {
        JWTAuth::invalidate($token);
        return response()->json([
            'status' => 'success',
            'message'=> "User successfully logged out."
        ]);
    } catch (JWTException $e) {
        // something went wrong whilst attempting to encode the token
        return response()->json([
          'status' => 'error',
          'message' => 'Failed to logout, please try again.'
        ], 500);
    }
  }

  // without email reset
  public function changepassword(Request $request)
  {
    $user = Auth::user();
    $validator = Validator::make($request->all(), [
          'password' => 'required|min:6|unique:users',
    ]);
    if ($validator->fails()) {
      return response()->json($validator->errors());
    }
    if ($user->update($request->only(['password']))) {
        return response()->json([
            'message' => 'You are changed your password successful',
            'code' => 200,
        ],200);
    } else {
        return response()->json([
            'message' => 'Internal Error',
            'code' => 500,
        ],500);
    }
  }
}
