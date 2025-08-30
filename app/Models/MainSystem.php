<?php

namespace App\Models;

use App\Traits\HasTranslationFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MainSystem extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;
    use HasTranslationFields;

    protected $table = 'main_systems';
    protected $guarded = [];

    public array $translatable = [
        'name',
        'description',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')->singleFile();
    }

    public function getImageAttribute($value)
    {
        // التحقق من وجود قيمة للصورة
        if ($value) {
            return url('attachments/main_systems/' . $value);
        }

        // Fallback to first media if exists
        $first = $this->getFirstMediaUrl('icon');
        if ($first) {
            return $first;
        }

        // إذا لم تكن هناك صورة، يمكن إرجاع صورة افتراضية
        return url('attachments/default.png');
    }
}
