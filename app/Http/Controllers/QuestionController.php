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
    public function show(int $id, int $offset)
    {
        $questions = Question::with([
            'question_options',
            'question_levels' => function ($query) {
                $query->select('id', 'reward_xp');
            },
        ])
        ->where('quiz_id', $id)
        ->offset($offset)
        ->limit(5)
        ->get();

        $option_ids = array_merge(...array_map(function ($question) {
            return array_map(function ($option) {
                return $option['id'];
            },$question['question_options']);
        }, $questions->toArray()));

        $answer_ids = array_column(Question_answer::select('question_option_id')->whereIn('question_option_id',$option_ids)->get()->toArray(),'question_option_id');

        $questions = $questions->each(function ($question) use ($answer_ids) {
            $question->question_options->each(function ($option) use ($answer_ids) {
                $option->isCorrect = array_search($option->id, $answer_ids) !== false;
            });
        });
        
        return Api::response(200, 'Fetch success', $questions);
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
