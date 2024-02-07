<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\Skills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User_skills_inventory;
use App\Http\Requests\StoreSkillsRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateSkillsRequest;
use App\Models\User_xp;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Api::response(200, 'Fetch success', Skills::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'logo' => 'required|file|mimetypes:image/*',
                'price' => 'required|integer',
                'cooldown_time' => 'required|integer',
                'disposable' => 'required|string',
                'active_time' => 'required|integer'
            ]);
    
            if ($validator->fails()) {
                return Api::response(400, "Invalid field", ["errors" => $validator->errors()]);
            }

            $logo_path = $request->file('logo')->store('skill_logos');
            $disposable = $request->disposable == 'true';

            Skills::create([
                'name' => $request->name,
                'description' => $request->description,
                'logo_path' => $logo_path,
                'price' => $request->price,
                'cooldown_time' => $request->cooldown_time,
                'disposable' => $disposable,
                'active_time' => $request->active_time
            ]);
    
            return Api::response(201, 'Created Successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Skills $skills)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skills $skills)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkillsRequest $request, Skills $skills)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skills $skills)
    {
        //
    }

    public function buy(int $id) {
        try {
            $user = Auth::user();
            $skill = Skills::findOrFail($id);
            $user_xp = User_xp::where('user_id', $user->id)->first();

            $inventory = User_skills_inventory::where('user_id', $user->id)->where('skills_id', $skill->id)->first();

            if ($user_xp->total_xp >= $skill->price) {
                if ($inventory) {
                    $inventory->quantity += 1;
                    
                    $inventory->save();
                } else {
                    User_skills_inventory::create([
                        'user_id' => $user->id,
                        'skills_id' => $skill->id,
                        'quantity' => 1
                    ]);
                }

                $user_xp->total_xp -= $skill->price;
                $user_xp->save();

            } else {
                return Api::response(403, 'Forbidden: XP is not enough');
            }
    
            return Api::response(201, 'Payment Success');
        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }
}
