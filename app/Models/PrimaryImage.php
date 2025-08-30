<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasTranslationFields;

class PrimaryImage extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;
    use HasTranslationFields;

    protected $table = 'primary_images';
    protected $guarded = [];

    public array $translatable = [
        'title',
        'description',
    ];



    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery_image')->singleFile();
    }

    public function getImageAttribute($value)
    {
        // التحقق من وجود قيمة للصورة
        if ($value) {
            return url('attachments/primaryimages/' . $value);
        }

        // Fallback to first media if exists
        $first = $this->getFirstMediaUrl('gallery_image');
        if ($first) {
            return $first;
        }

        // إذا لم تكن هناك صورة، يمكن إرجاع صورة افتراضية
        return url('attachments/default.png');
    }

    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class, 'primary_image_id');
    }
}
