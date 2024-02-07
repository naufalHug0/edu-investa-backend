<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\User;
use App\Models\User_skills_inventory;
use App\Models\User_xp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
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
            $is_admin = Admin::where('user_id', $auth->id)->first();

            if (!$is_admin) {
                $token = $auth->createToken('auth_token')->plainTextToken;
    
                return Api::response(200, "Login success", [
                    "access_token" => $token,
                    "token_type" => "Bearer"
                ]);
            }

            return Api::response(403, "Forbidden: Access is denied (User-only API endpoint)");

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
                return Api::response(400, "Invalid field", ["errors" => $validator->errors()]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);

            User_xp::create([
                'user_id'=>$user->id,
                'total_xp'=>0
            ]);

            return Api::response(201, "Created successfully");

        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    public function me()
    {
        try {
            $data = [];
            $user = Auth::user();

            $data[0] = $user->toArray();

            $xp = User_xp::select('total_xp')->where('user_id', $user->id)->first();

            if ($xp) {
                $data = array_merge($data[0], $xp->toArray());
            }

            $skills_inventory = User_skills_inventory::where('user_id', $user->id)->first();

            if ($skills_inventory) {
                $data['skills_inventory'] = $skills_inventory;
            }


            return Api::response(200, "Fetch success", $data);

        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

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
                return Api::response(400, "Invalid field", ["errors" => $validator->errors()]);
            }
    
            $user = Auth::user();
            
            if (!Hash::check($request->old_password, $user->password)) {
                return Api::response(400, 'old password did not match');
            }
            
            User::find($user->id)->update(['password' => Hash::make($request->new_password)]);
            
            return Api::response(200, 'Reset success');
        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

}
