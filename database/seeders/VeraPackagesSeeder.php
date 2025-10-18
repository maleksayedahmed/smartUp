<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Package;
use App\Models\PackageFeature;
use App\Models\PackageSystem;
use App\Models\PackageBenefit;
use App\Models\PackageSystemFeature;

class VeraPackagesSeeder extends Seeder
{
    public function run(): void
    {
        // Vera packages: Basic, Advanced, Premium, and a Custom package
        $packages = [
            'vera-basic' => [
                'title' => ['ar' => 'فيرا بيسك | 5 غرف', 'en' => 'Vera Basic | 5 Rooms'],
                'desc'  => [
                    'ar' => 'حل متكامل لبداية المنزل الذكي مع شاشات تحكم وموتورات ستائر وحساسات أساسية.',
                    'en' => 'An integrated starter smart-home set with control screens, curtain motors, and essential sensors.',
                ],
                'note'  => [
                    'ar' => 'تبدأ من 8,710 ريال (شاملة التركيب والبرمجة والضريبة).',
                    'en' => 'From SAR 8,710 (incl. installation, programming, and VAT).',
                ],
            ],
            'vera-advanced' => [
                'title' => ['ar' => 'فيرا أدفانسد | 9 غرف', 'en' => 'Vera Advanced | 9 Rooms'],
                'desc'  => [
                    'ar' => 'منظومة متقدمة مع شاشات متعددة، حساسات أمان، أقفال ذكية، وكاميرات مراقبة.',
                    'en' => 'A more advanced setup with multiple screens, security sensors, smart locks, and surveillance cameras.',
                ],
                'note'  => [
                    'ar' => 'تبدأ من 24,299 ريال (شاملة التركيب والبرمجة والضريبة).',
                    'en' => 'From SAR 24,299 (incl. installation, programming, and VAT).',
                ],
            ],
            'vera-premium' => [
                'title' => ['ar' => 'فيرا بريميوم | 16 غرفة', 'en' => 'Vera Premium | 16 Rooms'],
                'desc'  => [
                    'ar' => 'أعلى مستوى من التكامل مع شاشات مركزية متعددة، حساسات متقدمة، أقفال ذكية، وكاميرات عديدة.',
                    'en' => 'Top-tier integration with multiple central screens, advanced sensors, smart locks, and many cameras.',
                ],
                'note'  => [
                    'ar' => 'تبدأ من 56,999 ريال (شاملة التركيب والبرمجة والضريبة).',
                    'en' => 'From SAR 56,999 (incl. installation, programming, and VAT).',
                ],
            ],
            'vera-custom' => [
                'title' => ['ar' => 'فيرا مخصصة', 'en' => 'Vera Custom'],
                'desc'  => [
                    'ar' => 'صمّم باقتك كما تريد وفق المساحات والاحتياج والميزانية.',
                    'en' => 'Build your own package to match your spaces, needs, and budget.',
                ],
                'note'  => [
                    'ar' => 'مرونة كاملة في الإضافة والترقية.',
                    'en' => 'Full flexibility for add-ons and upgrades.',
                ],
            ],
        ];

        // Base systems catalog (titles/descriptions). Per-package counts/features are added via map overrides below.
        $systemsSeed = [
            'central-12-3' => [
                'title' => ['ar' => 'شاشة مركزية 12.3 إنش', 'en' => '12.3" Central Screen'],
                'description' => [
                    'ar' => 'تحكم مركزي بالمنزل الذكي (الإضاءة، الستائر، التكييف، التلفزيون) من شاشة كبيرة.',
                    'en' => 'Central control of lighting, curtains, AC, and TV from a large screen.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'واجهة سهلة الاستخدام', 'en' => 'Easy-to-use interface'],
                    ['ar' => 'تحكم شامل متعدد', 'en' => 'Comprehensive multi-control'],
                ],
            ],
            'central-7' => [
                'title' => ['ar' => 'شاشة مركزية 7 إنش', 'en' => '7" Central Screen'],
                'description' => [
                    'ar' => 'تحكم مركزي بالغرف والأنظمة (الإضاءة، الستائر، التكييف، التلفزيون).',
                    'en' => 'Central room/system control (lighting, curtains, AC, TV).',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'سيناريوهات قابلة للتخصيص', 'en' => 'Customizable scenes'],
                    ['ar' => 'تحكم لمس سلس', 'en' => 'Smooth touch control'],
                ],
            ],
            'central-4' => [
                'title' => ['ar' => 'شاشة مركزية 4 إنش', 'en' => '4" Central Screen'],
                'description' => [
                    'ar' => 'تحكم مركزي مدمج للإنارة والستائر والتكييف والتلفاز.',
                    'en' => 'Compact central control for lighting, curtains, AC, and TV.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'تحكم بالإضاءة والستائر', 'en' => 'Lighting and curtain control'],
                    ['ar' => 'تحكم بالتكييف والتلفزيون', 'en' => 'AC and TV control'],
                ],
            ],
            'sub-3' => [
                'title' => ['ar' => 'شاشة فرعية 3 إنش', 'en' => '3" Sub Screen'],
                'description' => [
                    'ar' => 'تحكم فرعي بالغرف (خطوط إنارة/ستائر/تكييف).',
                    'en' => 'Sub-room control (lighting lines/curtains/AC).',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'تحكم سريع للغرفة', 'en' => 'Quick room control'],
                ],
            ],
            'curtain-motor' => [
                'title' => ['ar' => 'ماطور ستارة', 'en' => 'Curtain Motor'],
                'description' => [
                    'ar' => 'تشغيل وإدارة الستائر كهربائياً مع التحكم عن بعد والمشاهد.',
                    'en' => 'Motorized curtains with remote control and scenes.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'تحكم فردي وجماعي', 'en' => 'Individual and group control'],
                ],
            ],
            'motion-sensor' => [
                'title' => ['ar' => 'حساس حركة', 'en' => 'Motion Sensor'],
                'description' => [
                    'ar' => 'اكتشاف الحركة لتنشيط الإنارة أو إطلاق تنبيهات الأمان.',
                    'en' => 'Detects motion to trigger lighting or security alerts.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'تنبيهات فورية', 'en' => 'Instant alerts'],
                ],
            ],
            'gas-sensor' => [
                'title' => ['ar' => 'حساس غاز (مدعوم بالذكاء الاصطناعي)', 'en' => 'Gas Sensor (AI-enabled)'],
                'description' => [
                    'ar' => 'مراقبة تسرب الغاز مع تحليل ذكي للتنبيهات.',
                    'en' => 'Monitors gas leak with intelligent alerting.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'أمان استباقي', 'en' => 'Proactive safety'],
                ],
            ],
            'smoke-sensor' => [
                'title' => ['ar' => 'حساس دخان (مدعوم بالذكاء الاصطناعي)', 'en' => 'Smoke Sensor (AI-enabled)'],
                'description' => [
                    'ar' => 'كشف الدخان والحرائق المبكر مع تنبيه فوري.',
                    'en' => 'Early fire/smoke detection with instant notification.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'موثوقية عالية', 'en' => 'High reliability'],
                ],
            ],
            'smart-lock' => [
                'title' => ['ar' => 'قفل ذكي', 'en' => 'Smart Lock'],
                'description' => [
                    'ar' => 'تحكم بفتح وإغلاق الباب عن بعد مع سجلات وصول.',
                    'en' => 'Remote door locking/unlocking with access logs.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'تحكم عن بعد', 'en' => 'Remote control'],
                    ['ar' => 'صلاحيات متعددة', 'en' => 'Multi-user permissions'],
                ],
            ],
            'smart-lock-internal' => [
                'title' => ['ar' => 'قفل ذكي داخلي', 'en' => 'Internal Smart Lock'],
                'description' => [
                    'ar' => 'قفل داخلي للأبواب داخل المنزل بتحكم ذكي.',
                    'en' => 'Smart internal lock for indoor doors.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'تحكم آمن وسهل', 'en' => 'Secure and easy control'],
                ],
            ],
            'intercom' => [
                'title' => ['ar' => 'إنتركوم ذكي', 'en' => 'Smart Intercom'],
                'description' => [
                    'ar' => 'تحكم وفتح البوابات الخارجية عن بعد مع اتصال مرئي/صوتي.',
                    'en' => 'Remotely control external gates with audio/video calling.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'اتصال مرئي وصوتي', 'en' => 'Video and audio call'],
                ],
            ],
            'camera-external' => [
                'title' => ['ar' => 'كاميرا خارجية', 'en' => 'External Camera'],
                'description' => [
                    'ar' => 'مراقبة خارجية بدقة عالية مع رؤية ليلية.',
                    'en' => 'High-resolution outdoor surveillance with night vision.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'رؤية ليلية', 'en' => 'Night vision'],
                    ['ar' => 'تنبيهات حركة', 'en' => 'Motion alerts'],
                ],
            ],
            'garage-relay' => [
                'title' => ['ar' => 'رلاي للتحكم بالكراج', 'en' => 'Garage Relay'],
                'description' => [
                    'ar' => 'تشغيل وإدارة باب الكراج عن بعد.',
                    'en' => 'Remote operation of the garage door.',
                ],
                'media' => [],
                'features' => [
                    ['ar' => 'تحكم آمن', 'en' => 'Secure control'],
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

            // Package-level feature bullets (summary)
            $featuresMap = [
                'vera-basic' => [
                    ['ar' => 'شاشتان مركزيتان 4 إنش', 'en' => 'Two 4" central screens'],
                    ['ar' => 'ثلاث شاشات فرعية 3 إنش', 'en' => 'Three 3" sub screens'],
                    ['ar' => 'عدد 2 ماطور ستارة', 'en' => 'Two curtain motors'],
                    ['ar' => 'حساس غاز مدعوم بالذكاء الاصطناعي', 'en' => 'AI-enabled gas sensor'],
                    ['ar' => 'قفل ذكي للتحكم عن بعد', 'en' => 'Smart lock with remote control'],
                ],
                'vera-advanced' => [
                    ['ar' => 'شاشة مركزية 7 إنش + ثلاث شاشات 4 إنش', 'en' => 'One 7" central + three 4" central screens'],
                    ['ar' => 'خمس شاشات فرعية 3 إنش', 'en' => 'Five 3" sub screens'],
                    ['ar' => 'أربع ماتورات ستائر', 'en' => 'Four curtain motors'],
                    ['ar' => 'حساسات حركة ×2 وغاز ×1 ودخان ×1 (بالذكاء الاصطناعي)', 'en' => 'Motion x2, Gas x1, Smoke x1 (AI-enabled)'],
                    ['ar' => 'قفل ذكي داخلي + إنتركوم + كاميرتان خارجيتان', 'en' => 'Internal smart lock + intercom + two external cameras'],
                ],
                'vera-premium' => [
                    ['ar' => 'شاشة مركزية 12.3 إنش + 3×7 إنش + 4×4 إنش', 'en' => '12.3" central + 3x 7" + 4x 4" central screens'],
                    ['ar' => 'ثماني شاشات فرعية 3 إنش', 'en' => 'Eight 3" sub screens'],
                    ['ar' => '10 ماتورات ستائر', 'en' => 'Ten curtain motors'],
                    ['ar' => 'حساسات حركة ×4 وغاز ×2 ودخان ×2 (بالذكاء الاصطناعي)', 'en' => 'Motion x4, Gas x2, Smoke x2 (AI-enabled)'],
                    ['ar' => 'رلاي كراج ×2 + 3 أقفال ذكية داخلية + 6 كاميرات', 'en' => '2x garage relays + 3 internal smart locks + 6 cameras'],
                ],
                'vera-custom' => [
                    ['ar' => 'اختر عدد الشاشات والمستشعرات وفق احتياجك', 'en' => 'Choose screens and sensors as needed'],
                    ['ar' => 'قابل للتوسع والترقية مستقبلًا', 'en' => 'Expandable and upgradable'],
                    ['ar' => 'توافق كامل مع Zigbee', 'en' => 'Full Zigbee compatibility'],
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

            // Global benefits applicable to all Vera packages
            $benefits = [
                ['number' => 'ZB',  'ar' => 'بروتوكول Zigbee آمن وغير متصل بالإنترنت', 'en' => 'Zigbee protocol, secure and offline'],
                ['number' => 'INT', 'ar' => 'سنترال داخلي مدمج للاتصال الداخلي', 'en' => 'Built-in internal intercom'],
                ['number' => 'EASY','ar' => 'قابلة للإزالة وتغيير الأماكن بسهولة', 'en' => 'Removable and easy to relocate'],
                ['number' => '2Y',  'ar' => 'ضمان سنتين', 'en' => '2-year warranty'],
                ['number' => '1Y',  'ar' => 'سنة ضمان لخدمة ما بعد البيع', 'en' => '1-year after-sales service'],
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

            // Per-package systems and their specific features/counts
            $map = [
                'vera-basic' => [
                    ['key' => 'central-4', 'features' => [
                        ['ar' => 'عدد 2 شاشة مركزية 4 إنش', 'en' => '2x 4" central screens'],
                        ['ar' => 'تحكم في 4 خطوط إنارة', 'en' => 'Control 4 lighting lines'],
                        ['ar' => 'تحكم بالستائر والتكييف والتلفزيون', 'en' => 'Curtains, AC, and TV control'],
                    ]],
                    ['key' => 'sub-3', 'features' => [
                        ['ar' => 'عدد 3 شاشات فرعية 3 إنش', 'en' => '3x 3" sub screens'],
                        ['ar' => 'تحكم في 3 خطوط إنارة', 'en' => 'Control 3 lighting lines'],
                        ['ar' => 'تحكم بالستائر والتكييف', 'en' => 'Curtains and AC control'],
                    ]],
                    ['key' => 'curtain-motor', 'features' => [
                        ['ar' => 'عدد 2 ماطور ستارة (الصالة وغرفة الماستر)', 'en' => '2x curtain motors (living room, master room)'],
                    ]],
                    ['key' => 'gas-sensor', 'features' => [
                        ['ar' => 'عدد 1 حساس غاز مدعوم بالذكاء الاصطناعي', 'en' => '1x AI-enabled gas sensor'],
                    ]],
                    ['key' => 'smart-lock', 'features' => [
                        ['ar' => 'عدد 1 قفل ذكي للتحكم عن بعد', 'en' => '1x smart lock with remote control'],
                    ]],
                ],
                'vera-advanced' => [
                    ['key' => 'central-7', 'features' => [
                        ['ar' => 'عدد 1 شاشة مركزية 7 إنش', 'en' => '1x 7" central screen'],
                        ['ar' => 'تحكم في 4 خطوط إنارة والستائر والتكييف والتلفزيون', 'en' => 'Control 4 lighting lines, curtains, AC and TV'],
                    ]],
                    ['key' => 'central-4', 'features' => [
                        ['ar' => 'عدد 3 شاشات مركزية 4 إنش', 'en' => '3x 4" central screens'],
                        ['ar' => 'تحكم في 4 خطوط إنارة والستائر والتكييف والتلفزيون', 'en' => 'Control 4 lighting lines, curtains, AC and TV'],
                    ]],
                    ['key' => 'sub-3', 'features' => [
                        ['ar' => 'عدد 5 شاشات فرعية 3 إنش', 'en' => '5x 3" sub screens'],
                        ['ar' => 'تحكم في 3 خطوط إنارة والستائر والتكييف', 'en' => 'Control 3 lighting lines, curtains and AC'],
                    ]],
                    ['key' => 'curtain-motor', 'features' => [
                        ['ar' => 'عدد 4 ماتورات ستائر (الصالات، غرفة الماستر، المجالس)', 'en' => '4x curtain motors (halls, master room, majlis)'],
                    ]],
                    ['key' => 'motion-sensor', 'features' => [
                        ['ar' => 'عدد 2 حساس حركة', 'en' => '2x motion sensors'],
                    ]],
                    ['key' => 'gas-sensor', 'features' => [
                        ['ar' => 'عدد 1 حساس غاز مدعوم بالذكاء الاصطناعي', 'en' => '1x AI-enabled gas sensor'],
                    ]],
                    ['key' => 'smoke-sensor', 'features' => [
                        ['ar' => 'عدد 1 حساس دخان مدعوم بالذكاء الاصطناعي', 'en' => '1x AI-enabled smoke sensor'],
                    ]],
                    ['key' => 'smart-lock-internal', 'features' => [
                        ['ar' => 'عدد 1 قفل ذكي داخلي للتحكم عن بعد', 'en' => '1x internal smart lock with remote control'],
                    ]],
                    ['key' => 'intercom', 'features' => [
                        ['ar' => 'عدد 1 إنتركوم ذكي للبوابات الخارجية', 'en' => '1x smart intercom for external gates'],
                    ]],
                    ['key' => 'camera-external', 'features' => [
                        ['ar' => 'عدد 2 كاميرات خارجية للمراقبة', 'en' => '2x external surveillance cameras'],
                    ]],
                ],
                'vera-premium' => [
                    ['key' => 'central-12-3', 'features' => [
                        ['ar' => 'عدد 1 شاشة مركزية 12.3 إنش', 'en' => '1x 12.3" central screen'],
                        ['ar' => 'تحكم متكامل (خطّان إنارة، الستائر، التكييف، التلفزيون)', 'en' => 'Integrated control (2 lighting lines, curtains, AC, TV)'],
                    ]],
                    ['key' => 'central-7', 'features' => [
                        ['ar' => 'عدد 3 شاشات مركزية 7 إنش', 'en' => '3x 7" central screens'],
                        ['ar' => 'تحكم في 4 خطوط إنارة والستائر والتكييف والتلفزيون', 'en' => 'Control 4 lighting lines, curtains, AC and TV'],
                    ]],
                    ['key' => 'central-4', 'features' => [
                        ['ar' => 'عدد 4 شاشات مركزية 4 إنش', 'en' => '4x 4" central screens'],
                        ['ar' => 'تحكم في 4 خطوط إنارة والستائر والتكييف والتلفزيون', 'en' => 'Control 4 lighting lines, curtains, AC and TV'],
                    ]],
                    ['key' => 'sub-3', 'features' => [
                        ['ar' => 'عدد 8 شاشات فرعية 3 إنش', 'en' => '8x 3" sub screens'],
                        ['ar' => 'تحكم في 3 خطوط إنارة والستائر والتكييف', 'en' => 'Control 3 lighting lines, curtains and AC'],
                    ]],
                    ['key' => 'curtain-motor', 'features' => [
                        ['ar' => 'عدد 10 ماتورات ستائر (الصالات، غرفة الماستر، المجالس)', 'en' => '10x curtain motors (halls, master room, majlis)'],
                    ]],
                    ['key' => 'motion-sensor', 'features' => [
                        ['ar' => 'عدد 4 حساسات حركة', 'en' => '4x motion sensors'],
                    ]],
                    ['key' => 'gas-sensor', 'features' => [
                        ['ar' => 'عدد 2 حساس غاز مدعوم بالذكاء الاصطناعي', 'en' => '2x AI-enabled gas sensors'],
                    ]],
                    ['key' => 'smoke-sensor', 'features' => [
                        ['ar' => 'عدد 2 حساس دخان مدعوم بالذكاء الاصطناعي', 'en' => '2x AI-enabled smoke sensors'],
                    ]],
                    ['key' => 'garage-relay', 'features' => [
                        ['ar' => 'عدد 2 رلاي للتحكم بالكراج عن بعد', 'en' => '2x garage relays for remote control'],
                    ]],
                    ['key' => 'smart-lock-internal', 'features' => [
                        ['ar' => 'عدد 3 أقفال ذكية داخلية', 'en' => '3x internal smart locks'],
                    ]],
                    ['key' => 'intercom', 'features' => [
                        ['ar' => 'عدد 1 إنتركوم ذكي للبوابات الخارجية', 'en' => '1x smart intercom for external gates'],
                    ]],
                    ['key' => 'camera-external', 'features' => [
                        ['ar' => 'عدد 6 كاميرات خارجية للمراقبة', 'en' => '6x external surveillance cameras'],
                    ]],
                ],
                'vera-custom' => [
                    ['key' => 'central-7'],
                    ['key' => 'central-4'],
                    ['key' => 'sub-3'],
                    ['key' => 'curtain-motor'],
                    ['key' => 'motion-sensor'],
                    ['key' => 'gas-sensor'],
                    ['key' => 'smoke-sensor'],
                    ['key' => 'smart-lock'],
                    ['key' => 'intercom'],
                    ['key' => 'camera-external'],
                    ['key' => 'garage-relay'],
                ],
            ];

            foreach ($map[$slug] as $sysEntry) {
                $sysKey = is_array($sysEntry) ? ($sysEntry['key'] ?? null) : (string)$sysEntry;
                if (!$sysKey || !isset($systemsSeed[$sysKey])) {
                    continue;
                }

                $sysData = $systemsSeed[$sysKey];

                $pkgSys = PackageSystem::firstOrCreate([
                    'package_id' => $package->id,
                    'slug' => $sysKey,
                ], [
                    'package_id' => $package->id,
                    'slug' => $sysKey,
                    'title' => $sysData['title'],
                    'title_ar' => $sysData['title']['ar'],
                    'title_en' => $sysData['title']['en'],
                    'description' => $sysData['description'],
                    'description_ar' => $sysData['description']['ar'],
                    'description_en' => $sysData['description']['en'],
                ]);

                // media
                foreach ($sysData['media'] as $media) {
                    if (isset($media['path']) && file_exists($media['path'])) {
                        $pkgSys->addMedia($media['path'])->preservingOriginal()->toMediaCollection('images');
                    }
                }

                // features: prefer package-specific overrides, fallback to base system features
                $features = is_array($sysEntry) && isset($sysEntry['features']) && is_array($sysEntry['features'])
                    ? $sysEntry['features']
                    : ($sysData['features'] ?? []);

                foreach ($features as $feature) {
                    if (!isset($feature['ar'], $feature['en'])) {
                        continue;
                    }
                    PackageSystemFeature::firstOrCreate([
                        'package_system_id' => $pkgSys->id,
                        'title->ar' => $feature['ar'],
                        'title->en' => $feature['en'],
                    ], [
                        'package_system_id' => $pkgSys->id,
                        'title' => ['ar' => $feature['ar'], 'en' => $feature['en']],
                        'title_ar' => $feature['ar'],
                        'title_en' => $feature['en'],
                    ]);
                }
            }
        }
    }
}
