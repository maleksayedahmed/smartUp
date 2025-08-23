<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimony;

class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name_ar' => 'سامح الزهير', 'name_en' => 'Sameh Al Zuhair',
                'position_ar' => 'مدير تسويق، جريدة الصباح', 'position_en' => 'Marketing Manager, Al Sabah',
                'content_ar' => 'الشراكة تتميز بدقة عالية، وطرح ممتاز وإبراز التفاصيل بشكل احترافي...',
                'content_en' => 'The partnership is highly precise with excellent presentation and professional details...'
            ],
            [
                'name_ar' => 'أحمد محمد', 'name_en' => 'Ahmed Mohammed',
                'position_ar' => 'مدير عام، شركة التقنية المتقدمة', 'position_en' => 'GM, Advanced Tech Co.',
                'content_ar' => 'خدمة متميزة وفريق محترف. تم تنفيذ المشروع في الوقت المحدد وبجودة عالية...',
                'content_en' => 'Outstanding service and professional team. The project was delivered on time and high quality...'
            ],
            [
                'name_ar' => 'فاطمة علي', 'name_en' => 'Fatimah Ali',
                'position_ar' => 'مديرة التسويق، مؤسسة الابتكار', 'position_en' => 'Marketing Manager, Innovation Org.',
                'content_ar' => 'تجربة استثنائية من البداية للنهاية. الفريق يتميز بالإبداع والالتزام...',
                'content_en' => 'Exceptional experience from start to finish. The team is creative and committed...'
            ],
        ];
        foreach ($items as $i) {
            Testimony::firstOrCreate([
                'name_ar' => $i['name_ar'], 'position_ar' => $i['position_ar']
            ], $i);
        }
    }
}


