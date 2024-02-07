<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storerisk_allocationRequest;
use App\Http\Requests\Updaterisk_allocationRequest;
use App\Models\risk_allocation;

class RiskAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function store(Storerisk_allocationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(risk_allocation $risk_allocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(risk_allocation $risk_allocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updaterisk_allocationRequest $request, risk_allocation $risk_allocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(risk_allocation $risk_allocation)
    {
        //
    }
}
