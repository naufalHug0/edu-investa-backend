<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function questions () {
        return $this->hasMany(Question::class);
    }

    public static function scopeWithQuestions($query, $id) {
        return $query->with(['questions', 'questions.question_levels', 'questions.question_options', 'questions.question_options.question_answers'])->findOrFail($id);
    }

    public static function scopeWithQuestionsCount($query) {
        return $query->withCount(['questions']);
    }

    public static function scopeWithTotalXpRewardsAndQuestionCount($query)
    {
        return $query->select('quizzes.*', 
        Quiz::raw('(select count(*) from `questions` where `quizzes`.`id` = `questions`.`quiz_id`) as `questions_count`'),
        Quiz::raw('SUM(question_levels.reward_xp) as total_reward'))
            ->join('questions', 'questions.quiz_id', '=', 'quizzes.id')
            ->join('question_levels', 'questions.level_id', '=', 'question_levels.id')
            ->groupBy('quizzes.id');
    }
}
