<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PackageSystemFeature extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'package_system_features';
    protected $guarded = [];

    public array $translatable = [
        'title',
    ];

    public function packageSystem()
    {
        return $this->belongsTo(PackageSystem::class);
    }
}
