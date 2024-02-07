<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\StoreAsset_changeRequest;
use App\Http\Requests\UpdateAsset_changeRequest;
use App\Models\Asset_change;
use App\Models\Investment_asset;

class AssetChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = Asset_change::with('investment_assets')->orderBy('created_at','desc')->get();
        $data = Investment_asset::with(['asset_changes' => function ($q) {
            $q->orderBy('created_at','asc')->get();
        }])->get();
        
        return Api::response(200, 'Fetch Success', $data); 
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
    public function store(StoreAsset_changeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset_change $asset_change)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset_change $asset_change)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAsset_changeRequest $request, Asset_change $asset_change)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset_change $asset_change)
    {
        //
    }
}
