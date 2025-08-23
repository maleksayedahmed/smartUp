<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $table = 'supports';
    protected $guarded = [];

      public function getImageAttribute($value)
    {

        // التحقق من وجود قيمة للصورة
        if ($value) {
            return url('attachments/supports/' . $value);
        }

        // إذا لم تكن هناك صورة، يمكن إرجاع صورة افتراضية
        return url('attachments/default.png');
    }
}
