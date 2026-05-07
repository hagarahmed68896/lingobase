<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'avatar',
        'language',
        'in_app_notifications',
        'email_notifications',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function grammarLessons()
    {
        return $this->belongsToMany(GrammarLesson::class, 'user_grammar_progress')->withTimestamps()->withPivot('completed_at');
    }

    public function stories()
    {
        return $this->belongsToMany(Story::class, 'user_story_progress')->withTimestamps()->withPivot('completed_at');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'in_app_notifications' => 'boolean',
            'email_notifications' => 'boolean',
        ];
    }
}
