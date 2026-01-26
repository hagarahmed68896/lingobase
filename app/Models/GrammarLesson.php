<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarLesson extends Model
{
    protected $fillable = ['grammar_level_id', 'title', 'slug', 'explanation', 'arabic_explanation', 'order'];

    public function grammarLevel()
    {
        return $this->belongsTo(GrammarLevel::class, 'grammar_level_id');
    }

    public function quiz()
    {
        return $this->hasOne(GrammarQuiz::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_grammar_progress')->withTimestamps()->withPivot('completed_at');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
}
