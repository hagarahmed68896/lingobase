<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarOption extends Model
{
    protected $fillable = ['grammar_question_id', 'option_text', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(GrammarQuestion::class, 'grammar_question_id');
    }
}
