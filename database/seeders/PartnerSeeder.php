<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $logos = [
            'DGALogo-01.svg',
            'Ministry-of-Media-01.svg',
            'الشعار_الأساسيملون(1).svg',
            'شعار_الهيئة_السعودية_للبيانات_والذكاء_الاصطناعي_SDAIA.svg.svg',
            'شعار_وزارة_الطاقة_(السعودية).svg.svg',
        ];

        $srcDir = public_path('assets/images/partners');
        $destDir = public_path('attachments/partners');
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        foreach ($logos as $filename) {
            $src = $srcDir.DIRECTORY_SEPARATOR.$filename;
            if (File::exists($src)) {
                $dest = $destDir.DIRECTORY_SEPARATOR.$filename;
                if (!File::exists($dest)) {
                    File::copy($src, $dest);
                }
                Partner::firstOrCreate([
                    'name' => pathinfo($filename, PATHINFO_FILENAME),
                ], [
                    'image' => $filename,
                ]);
            }
        }
    }
}


