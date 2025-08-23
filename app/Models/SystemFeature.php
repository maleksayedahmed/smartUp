<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SystemFeature extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'systems_features';
    protected $guarded = [];

    public array $translatable = [
        'title',
    ];

}
