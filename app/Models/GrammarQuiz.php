<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarQuiz extends Model
{
    protected $fillable = ['grammar_lesson_id', 'title'];

    public function lesson()
    {
        return $this->belongsTo(GrammarLesson::class, 'grammar_lesson_id');
    }

    public function questions()
    {
        return $this->hasMany(GrammarQuestion::class);
    }
}
