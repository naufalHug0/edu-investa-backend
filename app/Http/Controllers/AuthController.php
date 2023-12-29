<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{    
    public function login(Request $request)
    {
        try {
            if (!Auth::attempt(["username"=>$request->username, "password"=>$request->password])) {
                return Api::response(401, "Invalid username or password");
            }
    
            $auth = Auth::user();
            $token = $auth->createToken('auth_token')->plainTextToken;
    
            return Api::response(200, "Login success", [
                "access_token" => $token,
                "token_type" => "Bearer"
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    public function register(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email",
                "username"=>"required|unique:users",
                "password"=>"required"
            ]);
    
            if ($validator->fails()) {
                return Api::response(422, "Invalid field", ["errors" => $validator->errors()]);
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);

            return Api::response(201, "Created successfully");

        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    public function me()
    {
        try {
            $user = Auth::user();

            return Api::response(200, "Fetch success", $user);

        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();;

            return Api::response(200, "Logout successfully");

        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    public function reset_password(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                "old_password"=>"required",
                "new_password"=>"required"
            ]);
    
            if ($validator->fails()) {
                return Api::response(422, "Invalid field", ["errors" => $validator->errors()]);
            }
    
            $user = Auth::user();
            
            if (!Hash::check($request->old_password, $user->password)) {
                return Api::response(422, 'old password did not match');
            }
            
            User::find($user->id)->update(['password' => Hash::make($request->new_password)]);
            
            return Api::response(200, 'Reset success');
        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

}
