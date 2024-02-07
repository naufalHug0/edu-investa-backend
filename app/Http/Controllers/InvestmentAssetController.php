<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\Risk_profile;
use App\Models\Investment_asset;
use App\Http\Requests\StoreInvestment_assetRequest;
use App\Http\Requests\UpdateInvestment_assetRequest;

class InvestmentAssetController extends Controller
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
    public function store(StoreInvestment_assetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Investment_asset $investment_asset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Investment_asset $investment_asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvestment_assetRequest $request, Investment_asset $investment_asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Investment_asset $investment_asset)
    {
        //
    }

    public function getAllCurrentPrice()
    {
        $data = Risk_profile::with([
            'risk_allocations',
            'risk_allocations.investment_assets',
            'risk_allocations.investment_assets.asset_changes' => function ($q) {
                $q->orderBy('created_at', 'desc')->limit(3);
        }])->get();

        return Api::response(200, 'Fetch Success', $data); 
    }
}
