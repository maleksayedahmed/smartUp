<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Card extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'cards';
    protected $guarded = [];

    public array $translatable = [
        'title',
        'description',
    ];
}
