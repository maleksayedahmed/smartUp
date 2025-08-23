<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Package;
use App\Models\PackageFeature;
use App\Models\PackageSystem;
use App\Models\PackageBenefit;
use App\Models\PackageSystemFeature;

class PackagesSeeder extends Seeder
{
    public function run(): void
    {
        // Seed four packages per the page tabs: security, basic, integrated, custom
        $packages = [
            'security' => [
                'title' => ['ar' => 'باقة الأمان', 'en' => 'Security Package'],
                'desc'  => ['ar' => 'حماية لا تقبل المساومة! درع حماية متكامل يحرس بيتك.', 'en' => 'Uncompromising protection with an integrated shield guarding your home.'],
                'note'  => ['ar' => 'أفضل اختيار للحماية', 'en' => 'Best choice for security'],
            ],
            'basic' => [
                'title' => ['ar' => 'الباقة الأساسية', 'en' => 'Basic Package'],
                'desc'  => ['ar' => 'حلول ذكية بسيطة وفعالة لتحسين حياتك اليومية.', 'en' => 'Simple, effective smart solutions for daily life.'],
                'note'  => ['ar' => 'مناسبة للمبتدئين', 'en' => 'Good for starters'],
            ],
            'integrated' => [
                'title' => ['ar' => 'الباقة المتكاملة', 'en' => 'Integrated Package'],
                'desc'  => ['ar' => 'تحكم كامل في منزلك الذكي مع جميع الأنظمة المتقدمة.', 'en' => 'Full control of your smart home with advanced systems.'],
                'note'  => ['ar' => 'الأكثر تكاملا', 'en' => 'Most comprehensive'],
            ],
            'custom' => [
                'title' => ['ar' => 'باقة التفصيل', 'en' => 'Custom Package'],
                'desc'  => ['ar' => 'صمم باقتك الخاصة حسب احتياجاتك وميزانيتك.', 'en' => 'Build your package to match your needs and budget.'],
                'note'  => ['ar' => 'مرونة كاملة', 'en' => 'Full flexibility'],
            ],
        ];

        $systemsSeed = [
            'cameras' => [
                'title' => ['ar' => 'كاميرات مراقبة ذكية', 'en' => 'Smart Surveillance Cameras'],
                'description' => ['ar' => 'مراقبة دقيقة وبث مباشر وتحكم من أي مكان', 'en' => 'Accurate monitoring, live streaming, control anywhere'],
                'media' => [
                    ['path' => public_path('assets/images/camera2.png'), 'name' => 'camera2.png'],
                    ['path' => public_path('assets/images/campera.png'), 'name' => 'campera.png'],
                ],
                'features' => [
                    ['ar' => 'تحتوي على 7 أجهزة ذكية', 'en' => 'Includes 7 smart devices'],
                    ['ar' => 'دعم فني 6 شهور', 'en' => '6 months support'],
                    ['ar' => 'توفير الكهرباء', 'en' => 'Energy saving'],
                    ['ar' => 'اكتشاف الحركة', 'en' => 'Motion detection'],
                    ['ar' => 'التحكم من الهاتف', 'en' => 'Mobile control'],
                    ['ar' => 'بث مباشر HD', 'en' => 'HD live streaming'],
                ],
            ],
            'sensors' => [
                'title' => ['ar' => 'مستشعرات ذكية', 'en' => 'Smart Sensors'],
                'description' => ['ar' => 'حركة، تسرب مياه، غاز، حريق', 'en' => 'Motion, water leak, gas, fire'],
                'media' => [],
                'features' => [
                    ['ar' => 'كشف الحركة المتقدم', 'en' => 'Advanced motion detection'],
                    ['ar' => 'مراقبة تسرب المياه', 'en' => 'Water leak monitoring'],
                    ['ar' => 'كشف الغاز والحريق', 'en' => 'Gas and fire detection'],
                    ['ar' => 'تنبيهات فورية', 'en' => 'Instant alerts'],
                    ['ar' => 'حماية 24/7', 'en' => '24/7 protection'],
                    ['ar' => 'تغطية شاملة', 'en' => 'Wide coverage'],
                ],
            ],
            'locks' => [
                'title' => ['ar' => 'أقفال أبواب ذكية', 'en' => 'Smart Door Locks'],
                'description' => ['ar' => 'تحكم آمن ومرن في الوصول', 'en' => 'Secure, flexible access control'],
                'media' => [],
                'features' => [
                    ['ar' => 'فتح عن بعد', 'en' => 'Remote unlock'],
                    ['ar' => 'كلمات مرور رقمية', 'en' => 'PIN codes'],
                    ['ar' => 'بصمة الإصبع', 'en' => 'Fingerprint'],
                    ['ar' => 'سجل الوصول', 'en' => 'Access logs'],
                    ['ar' => 'تنبيهات الأمان', 'en' => 'Security alerts'],
                    ['ar' => 'تشفير متقدم', 'en' => 'Advanced encryption'],
                ],
            ],
            'alarm' => [
                'title' => ['ar' => 'نظام إنذار متكامل', 'en' => 'Integrated Alarm System'],
                'description' => ['ar' => 'حماية متقدمة مع تنبيهات فورية', 'en' => 'Advanced protection with instant alerts'],
                'media' => [],
                'features' => [
                    ['ar' => 'كشف التسلل', 'en' => 'Intrusion detection'],
                    ['ar' => 'تنبيهات صوتية', 'en' => 'Audible alerts'],
                    ['ar' => 'مراقبة 24/7', 'en' => '24/7 monitoring'],
                    ['ar' => 'اتصال بالشرطة', 'en' => 'Police integration'],
                    ['ar' => 'سجل الأحداث', 'en' => 'Event log'],
                    ['ar' => 'حماية شاملة', 'en' => 'Comprehensive protection'],
                ],
            ],
            'irrigation' => [
                'title' => ['ar' => 'نظام ذكي لري الحدائق', 'en' => 'Smart Irrigation'],
                'description' => ['ar' => 'ري ذكي يعتمد على الطقس', 'en' => 'Weather-based smart watering'],
                'media' => [],
                'features' => [
                    ['ar' => 'ري ذكي', 'en' => 'Smart watering'],
                    ['ar' => 'استشعار الرطوبة', 'en' => 'Moisture sensing'],
                    ['ar' => 'تحكم عن بعد', 'en' => 'Remote control'],
                    ['ar' => 'توفير المياه', 'en' => 'Water saving'],
                    ['ar' => 'جدولة الري', 'en' => 'Irrigation scheduling'],
                    ['ar' => 'مراقبة الطقس', 'en' => 'Weather monitoring'],
                ],
            ],
            'voltage' => [
                'title' => ['ar' => 'حماية من ارتفاع وانخفاض الجهد الكهربائي', 'en' => 'Voltage Protection'],
                'description' => ['ar' => 'حماية للأجهزة من تقلبات الجهد', 'en' => 'Protect devices from voltage fluctuations'],
                'media' => [],
                'features' => [
                    ['ar' => 'حماية من الارتفاع', 'en' => 'Over-voltage protection'],
                    ['ar' => 'حماية من الانخفاض', 'en' => 'Under-voltage protection'],
                    ['ar' => 'مراقبة مستمرة', 'en' => 'Continuous monitoring'],
                    ['ar' => 'تنبيهات فورية', 'en' => 'Instant alerts'],
                    ['ar' => 'حماية الأجهزة', 'en' => 'Device protection'],
                    ['ar' => 'استقرار الجهد', 'en' => 'Voltage stability'],
                ],
            ],
        ];

        foreach ($packages as $slug => $data) {
            $package = Package::firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $data['title'],
                    'desc'  => $data['desc'],
                    'note'  => $data['note'],
                    'title_ar' => $data['title']['ar'],
                    'title_en' => $data['title']['en'],
                    'desc_ar'  => $data['desc']['ar'],
                    'desc_en'  => $data['desc']['en'],
                    'note_ar'  => $data['note']['ar'],
                    'note_en'  => $data['note']['en'],
                    'slug'  => $slug,
                ]
            );

            $featuresMap = [
                'security' => [
                    ['ar' => 'تحتوي على 7 أجهزة ذكية', 'en' => 'Includes 7 smart devices'],
                    ['ar' => 'دعم فني 6 شهور', 'en' => '6 months support'],
                    ['ar' => 'توفير الكهرباء', 'en' => 'Energy saving'],
                    ['ar' => 'اكتشاف الحركة', 'en' => 'Motion detection'],
                    ['ar' => 'التحكم من الهاتف', 'en' => 'Mobile control'],
                    ['ar' => 'بث مباشر HD', 'en' => 'HD live streaming'],
                ],
                'basic' => [
                    ['ar' => 'التحكم بالإضاءة', 'en' => 'Lighting control'],
                    ['ar' => 'التحكم بدرجة ولون الإضاءة', 'en' => 'Color and temperature control'],
                    ['ar' => 'التحكم في المقابس', 'en' => 'Smart sockets control'],
                    ['ar' => 'تغطية شبكة واي فاي كاملة', 'en' => 'Full Wi‑Fi coverage'],
                ],
                'integrated' => [
                    ['ar' => 'التحكم بالإضاءة', 'en' => 'Lighting control'],
                    ['ar' => 'التحكم بدرجة ولون الإضاءة', 'en' => 'Color and temperature control'],
                    ['ar' => 'التحكم في المقابس', 'en' => 'Smart sockets control'],
                    ['ar' => 'تغطية شبكة واي فاي كاملة', 'en' => 'Full Wi‑Fi coverage'],
                    ['ar' => 'التحكم بالستائر', 'en' => 'Curtain control'],
                    ['ar' => 'مستشعرات ذكية', 'en' => 'Smart sensors'],
                    ['ar' => 'التحكم بالمكيف والتلفاز', 'en' => 'AC & TV control'],
                    ['ar' => 'التحكم الصوتي بالمنزل', 'en' => 'Voice control'],
                ],
            ];
            foreach (($featuresMap[$slug] ?? []) as $feature) {
                PackageFeature::firstOrCreate([
                    'package_id' => $package->id,
                    'title_ar' => $feature['ar'],
                ], [
                    'package_id' => $package->id,
                    'title' => ['ar' => $feature['ar'], 'en' => $feature['en']],
                    'title_ar' => $feature['ar'],
                    'title_en' => $feature['en'],
                ]);
            }

            // Global Key Benefits (as per page): number + label
            $benefits = [
                ['number' => '∞',    'ar' => 'راحة البال',     'en' => 'Peace of mind'],
                ['number' => '24/7', 'ar' => 'تحكم مستمرة',    'en' => 'Always in control'],
                ['number' => '30%',  'ar' => 'توفير الكهرباء',  'en' => 'Energy saving'],
                ['number' => '7',    'ar' => 'أجهزة ذكية',     'en' => 'Smart devices'],
            ];
            foreach ($benefits as $b) {
                PackageBenefit::firstOrCreate([
                    'package_id' => $package->id,
                    'number' => $b['number'],
                ], [
                    'package_id' => $package->id,
                    'number' => $b['number'],
                    'label' => ['ar' => $b['ar'], 'en' => $b['en']],
                    'label_ar' => $b['ar'],
                    'label_en' => $b['en'],
                    'icon' => null,
                ]);
            }

            // Create package-specific systems
            $map = [
                'security'   => ['cameras', 'sensors', 'locks', 'alarm', 'irrigation', 'voltage'],
                'basic'      => ['locks', 'sensors'],
                'integrated' => ['cameras', 'sensors', 'locks', 'alarm', 'irrigation'],
                'custom'     => ['cameras'],
            ];
            foreach ($map[$slug] as $sysKey) {
                $sysData = $systemsSeed[$sysKey];
                $pkgSys = PackageSystem::firstOrCreate([
                    'package_id' => $package->id,
                    'slug' => $sysKey,
                ], [
                    'package_id' => $package->id,
                    'slug' => $sysKey,
                    'title' => $sysData['title'],
                    'description' => $sysData['description'],
                ]);
                // media
                foreach ($sysData['media'] as $media) {
                    if (file_exists($media['path'])) {
                        $pkgSys->addMedia($media['path'])->preservingOriginal()->toMediaCollection('images');
                    }
                }
                // features
                foreach ($sysData['features'] as $feature) {
                    PackageSystemFeature::firstOrCreate([
                        'package_system_id' => $pkgSys->id,
                        'title->ar' => $feature['ar'],
                        'title->en' => $feature['en'],
                    ], [
                        'package_system_id' => $pkgSys->id,
                        'title' => ['ar' => $feature['ar'], 'en' => $feature['en']],
                    ]);
                }
            }
        }
    }
}


