<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PackageSystem extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $table = 'package_systems';
    protected $guarded = [];

    public array $translatable = [
        'title',
        'description',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function features()
    {
        return $this->hasMany(PackageSystemFeature::class);
    }
}
