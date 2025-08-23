<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class System extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected $table = 'systems';
    protected $guarded = [];

    public array $translatable = [
        'title',
        'desctiption',
    ];

    // Backward compatibility for admin listing using $system->image
    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return url('attachments/systems/' . $value);
        }
        // Fallback to first media if exists
        $first = $this->getFirstMediaUrl('images');
        if ($first) {
            return $first;
        }
        return url('attachments/default.png');
    }

    public function features()
    {
        return $this->hasMany(SystemFeature::class, 'system_id', 'id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_systems', 'system_id', 'package_id');
    }
}
