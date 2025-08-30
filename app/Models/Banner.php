<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\HasTranslationFields;
class Banner extends Model
{
    use HasFactory;
    use HasTranslations;
    use HasTranslationFields;

    protected $table = 'banners';
    protected $guarded = [];

    public array $translatable = [
        'title',
        'description',
    ];


}
