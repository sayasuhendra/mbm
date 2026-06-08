<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    public static function value(string $key, mixed $default = null): mixed
    {
        return cache()->remember("setting:{$key}", 300, fn () => self::query()->where('key', $key)->value('value') ?? $default);
    }
}
