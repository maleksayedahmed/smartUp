<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageSpec extends Model
{
    use HasFactory;

    protected $table = 'package_spec';
    protected $guarded = [];

    public function getImageAttribute($value)
    {

        // التحقق من وجود قيمة للصورة
        if ($value) {
            return url('attachments/package_spec/' . $value);
        }

        // إذا لم تكن هناك صورة، يمكن إرجاع صورة افتراضية
        return url('attachments/default.png');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }


}
