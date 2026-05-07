<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacementAnswer extends Model
{
    use HasFactory;

    protected $table = 'user_placement_answers';
    protected $guarded = [];

    public function test()
    {
        return $this->belongsTo(PlacementTest::class, 'user_placement_test_id');
    }

    public function question()
    {
        return $this->belongsTo(PlacementQuestion::class, 'placement_question_id');
    }

    public function option()
    {
        return $this->belongsTo(PlacementOption::class, 'selected_option_id');
    }
}
