<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarLevel extends Model
{
    protected $fillable = ['language_id', 'name', 'slug'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function lessons()
    {
        return $this->hasMany(GrammarLesson::class);
    }
}
