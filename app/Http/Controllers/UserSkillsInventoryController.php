<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\Skills;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User_skills_inventory;
use App\Http\Requests\StoreUser_skills_inventoryRequest;
use App\Http\Requests\UpdateUser_skills_inventoryRequest;

class UserSkillsInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        $user_skills = Skills::select('skills.*', 'user_skills_inventories.id as inventory_id', 'user_skills_inventories.quantity')
        ->join('user_skills_inventories', function ($join) use ($user) {
            $join->on('skills.id', '=', 'user_skills_inventories.skills_id')
                ->where('user_skills_inventories.user_id', '=', $user->id);
        })
        ->get();

        return Api::response(200, 'Fetch success', $user_skills);
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
    public function store(StoreUser_skills_inventoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User_skills_inventory $user_skills_inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User_skills_inventory $user_skills_inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser_skills_inventoryRequest $request, User_skills_inventory $user_skills_inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User_skills_inventory $user_skills_inventory)
    {
        //
    }
}
