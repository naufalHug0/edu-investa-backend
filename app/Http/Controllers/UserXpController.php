<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\StoreUser_xpRequest;
use App\Http\Requests\UpdateUser_xpRequest;
use App\Models\User_xp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserXpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users_xp = User_xp::selectRaw('user_xps.total_xp, user_xps.user_id')->with([
            'users' => function ($query) {
                $query->select('id','username');
        }])->orderBy('total_xp','DESC')->limit(5)->get();

        return Api::response(200, 'Fetch success', $users_xp);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User_xp $user_xp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User_xp $user_xp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_xp' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return Api::response(400, "Bad request", ["errors" => $validator->errors()]);
        }

        $user = Auth::user();

        $user_xp = User_xp::where('user_id', $user->id)->first();

        $user_xp->total_xp += $request->total_xp;

        $user_xp->save();

        return Api::response(201, 'Update success'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_xp $user_xp)
    {
        //
    }
}
