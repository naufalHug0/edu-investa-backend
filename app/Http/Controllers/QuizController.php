<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateQuizRequest;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Api::response(200, 'Fetch success', Quiz::all());

        } catch (\Illuminate\Database\QueryException $e) {
            return Api::serverError($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'duration' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return Api::response(400, "Invalid field", ["errors" => $validator->errors()]);
        }

        Quiz::create([
            'title' => $request->title,
            'description' => $request['description'],
            'duration' => $request['duration']
        ]);

        return Api::response(201, "Created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $quiz = Quiz::with(['questions','questions.question_levels','questions.question_options','questions.question_options.question_answers'])->findOrFail($id);

        return Api::response(200, "Fetch success", $quiz);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
