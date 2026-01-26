<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarQuestion extends Model
{
    protected $fillable = ['grammar_quiz_id', 'question', 'type'];

    public function quiz()
    {
        return $this->belongsTo(GrammarQuiz::class, 'grammar_quiz_id');
    }

    public function options()
    {
        return $this->hasMany(GrammarOption::class);
    }
}
