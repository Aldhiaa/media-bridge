<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'autoload',
    ];

    protected function casts(): array
    {
        return [
            'autoload' => 'boolean',
        ];
    }

    public static function value(string $key, mixed $default = null): mixed
    {
        return static::query()->where('key', $key)->value('value') ?? $default;
    }
}
