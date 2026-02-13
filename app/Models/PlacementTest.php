<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacementTest extends Model
{
    use HasFactory;

    protected $table = 'user_placement_tests';
    protected $guarded = [];

    protected $casts = [
        'question_sequence' => 'array',
        'current_question_index' => 'integer',
        'total_score' => 'decimal:2',
        'grammar_score' => 'decimal:2',
        'vocabulary_score' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(PlacementAnswer::class, 'user_placement_test_id');
    }
}
