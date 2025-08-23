<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PackageBenefit extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'package_benefits';
    protected $guarded = [];

    public array $translatable = [
        'label',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}


