<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name', 'code', 'slug'];

    public function grammarLevels()
    {
        return $this->hasMany(GrammarLevel::class);
    }

    public function storyLevels()
    {
        return $this->hasMany(StoryLevel::class);
    }
}
