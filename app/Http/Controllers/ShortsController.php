<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\Shorts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreShortsRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateShortsRequest;

class ShortsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Api::response(200, 'Fetch success', Shorts::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'video' => 'required|file|mimetypes:video/mp4',
                'image' => 'required|file|mimetypes:image/*',
            ]);
    
            if ($validator->fails()) {
                return Api::response(400, "Invalid field", ["errors" => $validator->errors()]);
            }
    
            // video upload
            $videoPath = $request->file('video')->store('shorts');
    
            // image upload
            $thumbnail_path = $request->file('image')->store('thumbnails');
    
            $shorts = Shorts::create([
                'title' => $request->title,
                'thumbnail_path' => $thumbnail_path,
                'video_path' => $videoPath,
            ]);
    
            return Api::response(201, 'Created Successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShortsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $shorts = Shorts::orderByRaw("id = $id DESC")->orderBy('id', 'asc')->get();
        $shorts[] = Shorts::find(1);

        return Api::response(200, 'Fetch Success', $shorts); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shorts $shorts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShortsRequest $request, Shorts $shorts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shorts $shorts)
    {
        //
    }
}
