<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Helpers\Api;
use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Api::response(200, 'Fetch success', Course::with('course_levels')->withCount('videos')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'videos' => 'required|array',
                'videos.*.title' => 'required|string|max:255',
                'videos.*.description' => 'required|string|max:255',
                'videos.*.duration' => 'required|integer',
                'videos.*.video' => 'required|file|mimetypes:video/mp4',
                'videos.*.thumbnail' => 'required|file|mimetypes:image/*',
            ]);
    
            if ($validator->fails()) {
                return Api::response(400, "Invalid field", ["errors" => $validator->errors()]);
            }

            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $videosData = [];
            foreach ($request->videos as $video) {
                // video upload
                $videoPath = $video['video']->store('courses');
        
                // // image upload
                $thumbnail_path = $video['thumbnail']->store('thumbnails');

                $videosData[] = [
                    'title' => $video['title'],
                    'description' => $video['description'],
                    'thumbnail_path' => $thumbnail_path,
                    'video_path' => $videoPath,
                    'duration' => intval($video['duration']),
                    'is_premium' => $video['is_premium'] == 'true',
                    'course_id' => $course->id
                ];
            }

            Video::insert($videosData);
    
            return Api::response(201, 'Created Successfully');
            
        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return Api::response(200, 'Fetch success', Course::with(['course_levels','videos'])->withCount('videos')->findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
