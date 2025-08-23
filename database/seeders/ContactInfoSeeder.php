<?php

namespace Database\Seeders;

use App\Models\ContactInfo ;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\File;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

                // حذف البيانات القديمة إذا وجدت
        ContactInfo::query()->delete();

        // مسار الصورة الافتراضية
        $defaultImage = 'image.png';
        $imagePath = public_path('images/' . $defaultImage);

        // التحقق من وجود الصورة
        if (!File::exists($imagePath)) {
            $this->command->error("الصورة الافتراضية غير موجودة في: " . $imagePath);
            return;
        }

        $contact_info = ContactInfo::create([
            'mobile' => '+966501234567',
            'email' => 'info@example.com',
            'facebook' => 'https://facebook.com/example',
            'instagram' => 'https://instagram.com/example',
            'tiktok' => 'https://tiktok.com/@example',
            'youtube' => 'https://youtube.com/example',
            'whatsapp' => '+966501234567',
            'linkedin' => 'https://linkedin.com/company/example',
            'X' => 'https://twitter.com/example',
            'address' => 'الرياض، المملكة العربية السعودية',
            'logo' => 'images/' . $defaultImage, // المسار النسبي للصورة
            'site_name' => 'موقعنا الإلكتروني',
        ]);


    }
}
