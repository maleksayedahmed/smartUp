<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PackageFeature extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'package_features';
    protected $guarded = [];

    public array $translatable = [
        'title',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

}
