<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['story_level_id', 'title', 'slug', 'content', 'arabic_comment', 'excerpt', 'image_url', 'audio_url'];

    public function storyLevel()
    {
        return $this->belongsTo(StoryLevel::class, 'story_level_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_story_progress')->withTimestamps()->withPivot('completed_at');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
}
