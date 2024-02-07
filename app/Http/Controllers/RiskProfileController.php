<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\risk_profile;
use App\Http\Requests\Storerisk_profileRequest;
use App\Http\Requests\Updaterisk_profileRequest;

class RiskProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Risk_profile::all();

        return Api::response(200, 'Fetch success',$data);
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
    public function store(Storerisk_profileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(risk_profile $risk_profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(risk_profile $risk_profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updaterisk_profileRequest $request, risk_profile $risk_profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(risk_profile $risk_profile)
    {
        //
    }
}
