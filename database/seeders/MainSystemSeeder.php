<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\MainSystem;

class MainSystemSeeder extends Seeder
{
    public function run(): void
    {
        $systems = [
            [
                'name' => [
                    'ar' => 'الشاشات الذكية',
                    'en' => 'Smart Displays'
                ],
                'description' => [
                    'ar' => 'نوفر أحدث تقنيات الشاشات الذكية مع إمكانية التحكم الكامل والتكامل مع جميع الأجهزة المنزلية',
                    'en' => 'We provide the latest smart display technologies with full control capabilities and integration with all home devices'
                ],
                'image' => 'icon here.svg'
            ],
            [
                'name' => [
                    'ar' => 'المفاتيح الذكية',
                    'en' => 'Smart Switches'
                ],
                'description' => [
                    'ar' => 'مفاتيح ذكية متطورة تتيح التحكم في الإضاءة والأجهزة عن بُعد مع تصاميم عصرية وأنيقة',
                    'en' => 'Advanced smart switches that allow remote control of lighting and devices with modern and elegant designs'
                ],
                'image' => 'icon here-2.svg'
            ],
            [
                'name' => [
                    'ar' => 'الأقفال الذكية',
                    'en' => 'Smart Locks'
                ],
                'description' => [
                    'ar' => 'أنظمة أمان متقدمة مع أقفال ذكية تدعم البصمة والرقم السري والتطبيق الذكي',
                    'en' => 'Advanced security systems with smart locks supporting fingerprint, PIN, and smart app access'
                ],
                'image' => 'icon here-2.svg'
            ],
            [
                'name' => [
                    'ar' => 'الكاميرات الذكية',
                    'en' => 'Smart Cameras'
                ],
                'description' => [
                    'ar' => 'أنظمة مراقبة متطورة مع كاميرات ذكية عالية الدقة وإمكانية المراقبة عن بُعد',
                    'en' => 'Advanced surveillance systems with high-definition smart cameras and remote monitoring capabilities'
                ],
                'image' => 'Security Camera Icon.svg'
            ],
            [
                'name' => [
                    'ar' => 'النظام الصوتي',
                    'en' => 'Audio System'
                ],
                'description' => [
                    'ar' => 'أنظمة صوتية متطورة عالية الجودة مع إمكانية التحكم الصوتي والتشغيل اللاسلكي',
                    'en' => 'Advanced high-quality audio systems with voice control and wireless operation capabilities'
                ],
                'image' => 'icon here-3.svg'
            ],
            [
                'name' => [
                    'ar' => 'الستائر الذكية',
                    'en' => 'Smart Curtains'
                ],
                'description' => [
                    'ar' => 'ستائر آلية ذكية قابلة للبرمجة مع التحكم في الإضاءة والخصوصية تلقائياً',
                    'en' => 'Programmable smart automated curtains with automatic lighting and privacy control'
                ],
                'image' => 'icon here-4.svg'
            ],
            [
                'name' => [
                    'ar' => 'الإضاءات الذكية',
                    'en' => 'Smart Lighting'
                ],
                'description' => [
                    'ar' => 'مجموعة متكاملة من الحلول الذكية للتحكم في جميع أجهزة المنزل من مكان واحد',
                    'en' => 'Integrated smart solutions for controlling all home devices from a single location'
                ],
                'image' => 'icon here-5.svg'
            ],
            [
                'name' => [
                    'ar' => 'أجهزة استشعار ذكية',
                    'en' => 'Smart Sensors'
                ],
                'description' => [
                    'ar' => 'أجهزة استشعار متطورة للحركة والحرارة والرطوبة مع تنبيهات فورية وتحكم ذكي',
                    'en' => 'Advanced motion, temperature, and humidity sensors with instant alerts and smart control'
                ],
                'image' => 'icon here-6.svg'
            ]
        ];

        $srcDir = public_path('assets/images');
        $destDir = public_path('attachments/main_systems');
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        foreach ($systems as $systemData) {
            $system = MainSystem::firstOrCreate(
                ['name->ar' => $systemData['name']['ar']],
                [
                    'name' => $systemData['name'],
                    'name_ar' => $systemData['name']['ar'],
                    'name_en' => $systemData['name']['en'],
                    'description' => $systemData['description'],
                    'description_ar' => $systemData['description']['ar'],
                    'description_en' => $systemData['description']['en'],
                    'image' => $systemData['image']
                ]
            );

            // Copy icon file if exists
            $srcFile = $srcDir . DIRECTORY_SEPARATOR . $systemData['image'];
            if (File::exists($srcFile)) {
                $destFile = $destDir . DIRECTORY_SEPARATOR . $systemData['image'];
                if (!File::exists($destFile)) {
                    File::copy($srcFile, $destFile);
                }

                // Attach media using Spatie Media Library
                if ($system->getMedia('icon')->isEmpty()) {
                    $system->addMedia($srcFile)
                        ->toMediaCollection('icon');
                }
            }
        }
    }
}
