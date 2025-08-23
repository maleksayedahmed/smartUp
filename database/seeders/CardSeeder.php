<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Card;

class CardSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            [
                'title' => [
                    'ar' => 'ما نقدم به',
                    'en' => 'What We Offer'
                ],
                'description' => [
                    'ar' => 'نؤمن أن التكنولوجيا الذكية يجب أن تكون بديهية وتتكيف مع احتياجات العائلة السعودية الحديثة.',
                    'en' => 'We believe that smart technology should be intuitive and adapt to the needs of the modern Saudi family.'
                ],
            ],
            [
                'title' => [
                    'ar' => 'فلسفتنا في الابتكار',
                    'en' => 'Our Innovation Philosophy'
                ],
                'description' => [
                    'ar' => 'التكنولوجيا يجب أن تعزز حياتك اليومية بسلاسة. نؤمن أن كل منزل يستحق حلولاً ذكية.',
                    'en' => 'Technology should seamlessly enhance your daily life. We believe every home deserves smart solutions.'
                ],
            ],
            [
                'title' => [
                    'ar' => 'ما نتطور به',
                    'en' => 'How We Evolve'
                ],
                'description' => [
                    'ar' => 'اختبر التركيب السهل والدعم المحلي على مدار الساعة والتكنولوجيا التي تعمل بكفاءة.',
                    'en' => 'Experience easy installation, 24/7 local support, and technology that works efficiently.'
                ],
            ],
            [
                'title' => [
                    'ar' => 'ما نتوقعه',
                    'en' => 'What We Anticipate'
                ],
                'description' => [
                    'ar' => 'نقوم بتصميم وتركيب أنظمة المنازل الذكية المتطورة عبر المملكة العربية السعودية.',
                    'en' => 'We design and install advanced smart home systems across the Kingdom of Saudi Arabia.'
                ],
            ]
        ];

        foreach ($cards as $card) {
            Card::firstOrCreate(
                ['title->ar' => $card['title']['ar']],
                $card
            );
        }
    }
}