<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\User_investment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUser_investmentRequest;
use App\Http\Requests\UpdateUser_investmentRequest;

class UserInvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $investment = User_investment::with('user_investment_changes')->where('user_id',$user->id)->get();

        return Api::response(200, 'Fetch Success', $investment); 
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
    public function store(StoreUser_investmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User_investment $user_investment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User_investment $user_investment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser_investmentRequest $request, User_investment $user_investment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_investment $user_investment)
    {
        //
    }
}
