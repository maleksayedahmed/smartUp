<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')
            ->singleFile();
            
        $this->addMediaCollection('image1')
            ->singleFile();
            
        $this->addMediaCollection('image2')
            ->singleFile();
            
        $this->addMediaCollection('video')
            ->singleFile();
    }

    /**
     * Register media conversions
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->performOnCollections('icon', 'image1', 'image2');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function features()
    {
        return $this->hasMany(PackageSystemFeature::class);
    }
}
