<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryLevel extends Model
{
    protected $fillable = ['language_id', 'name', 'slug'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}
