<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacementSetting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
