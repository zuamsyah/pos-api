<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use JWTAuthException;
use App\Models\User;

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
            // Coba verifikasi kredensial dan buat token untuk pengguna
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "We can't find an account with this credentials."
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to login, please try again.'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'user' => $request->username,
            'token_type' => 'Bearer',
            'data'=> [
                'token' => $token
            ],
        ]);
    }
    
    public function register(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'username' => 'required|alpha_dash|min:3|max:10|unique:users',
            'email' => 'required|email|min:5|max:255|unique:users',
            'password'=> 'required|min:6'
            ]);

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
        $token = $request->header('Authorization');
        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'status' => 'success',
                'message'=> "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            return response()->json([
            'status' => 'error',
            'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }

    // without email reset
    public function updatePassword(Request $request)
    {
        $data = $request->all();
        $user = User::find(Auth::id());
        $this->validate($request,[
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);
        
        if (!Hash::check($data['old_password'], $user->password)) {
            return response()->json([
                'success' => false, 
                'message' => 'The specified password does not match the database password'
            ],406);
        } else {
            Auth::user()->update($request->only(['password']));
            return response()->json([
                        'message' => 'You are changed your password successful',
                        'code' => 200,
                    ],200);
        }
    }
}
