<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login(Request $request) {
        try {
            if (!Auth::attempt(["username"=>$request->username, "password"=>$request->password])) {
                return Api::response(401, "Invalid username or password");
            }
    
            $auth = Auth::user();
            $is_admin = Admin::where('user_id', $auth->id)->first();

            if ($is_admin) {
                $token = $auth->createToken('auth_token')->plainTextToken;
    
                return Api::response(200, "Login success", [
                    "access_token" => $token,
                    "token_type" => "Bearer"
                ]);
            }

            return Api::response(403, "Forbidden: Access is denied (Admin-only API endpoint)");

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

            Admin::create([
                'user_id' => $user->id
            ]);

            return Api::response(201, "Created successfully");

        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
