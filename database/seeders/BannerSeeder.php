<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;
use Illuminate\Support\Facades\Log;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => [
                    'ar' => 'ابــنـي <span class="highlight">المستقبـــــل</span> بـحلول <br>ذكـية مــتطـورة',
                    'en' => 'Build the <span class="highlight">Future</span> with Smart <br>Advanced Solutions'
                ],
                'description' => [
                    'ar' => 'عيش تجربة مريحة وآمنة بتحكم كامل من جوالك — من الإضاءة للتكييف، ومن الستائر إلى الأنظمة الصوتية، كل شي بلمسة وحدة.',
                    'en' => 'Experience a comfortable and secure lifestyle with complete control from your phone — from lighting to air conditioning, from curtains to audio systems, everything with one touch.'
                ],
            ]
        ];

        foreach ($banners as $banner) {

            Banner::firstOrCreate(
                [
                    'title' => $banner['title'],
                    'title_ar' => $banner['title']['ar'],
                    'title_en' => $banner['title']['en'],
                    'description' => $banner['description'],
                    'description_ar' => $banner['description']['ar'],
                    'description_en' => $banner['description']['en'],
                ]
            );
        }
    }
}
