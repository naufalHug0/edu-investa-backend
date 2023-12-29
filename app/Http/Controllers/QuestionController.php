<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Question_answer;
use App\Models\Question_option;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;

class QuestionController extends Controller
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
    public function create(int $id, Request $request)
    {   
        if (!Quiz::find($id)) {
            return Api::response(404, "Entity not found");
        }

        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'level_id' => 'required|integer',
            'option' => 'required|array|min:4|max:4',
            'option.*.text' => 'required',
            'option.*.isCorrect' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return Api::response(400, "Invalid field", ["errors" => $validator->errors()]);
        }

        $question = Question::create([
            'quiz_id' => $id,
            'text' => $request->text,
            'level_id' => $request->level_id
        ]);

        array_map(function ($option) use ($question) {
            $question_option = Question_option::create([
                'question_id' => $question->id,
                'text' => $option['text']
            ]);

            if ($option['isCorrect']) {
                Question_answer::create([
                    "question_option_id"=>$question_option->id
                ]);
            }
        }, $request->option);

        return Api::response(201, "Created successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
