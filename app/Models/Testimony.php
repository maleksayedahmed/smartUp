<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    protected $table = 'testimonials';
    protected $guarded = [];

//     public function getImageAttribute($value)
//     {

//         // التحقق من وجود قيمة للصورة
//         if ($value) {
//             return url('attachments/testimonials/' . $value);
//         }

//         // إذا لم تكن هناك صورة، يمكن إرجاع صورة افتراضية
//         return url('attachments/default.png');
//     }
}
