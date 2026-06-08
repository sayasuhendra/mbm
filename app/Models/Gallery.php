<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model implements \Spatie\MediaLibrary\HasMedia
{
    use \Spatie\MediaLibrary\InteractsWithMedia;

    protected $fillable = ['title', 'description', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
