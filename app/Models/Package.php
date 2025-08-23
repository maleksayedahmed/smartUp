<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Package extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $table = 'packages';
    protected $guarded = [];

    public array $translatable = [
        'title',
        'desc',
        'note',
    ];

    public function features()
    {
        return $this->hasMany(PackageFeature::class, 'package_id');
    }
    public function packageSpec()
    {
        return $this->hasMany(PackageSpec::class, 'package_id');
    }

    public function systems()
    {
        return $this->hasMany(PackageSystem::class);
    }

    public function benefits()
    {
        return $this->hasMany(PackageBenefit::class);
    }

}
