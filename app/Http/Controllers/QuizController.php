<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Question;
use App\Models\Question_answer;
use App\Models\Question_option;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Api::response(200, 'Fetch success', Quiz::withTotalXpRewardsAndQuestionCount()->get());

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
            'questions' => 'required|array',
            'questions.*.text' => 'required|string|max:255',
            'questions.*.level_id' => 'required|integer',
            'questions.*.options' => 'required|array',
            'questions.*.options.*.text' => 'required|string|max:255',
            'questions.*.options.*.isCorrect' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return Api::response(400, "Invalid field", ["errors" => $validator->errors()]);
        }

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request['description'],
            'duration' => $request['duration']
        ]);

        foreach ($request->questions as $q) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'text' => $q['text'],
                'level_id' => $q['level_id']
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
            }, $q['options']);
        }

        return Api::response(201, "Created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $quiz = Quiz::withTotalXpRewardsAndQuestionCount()->findOrFail($id);

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
