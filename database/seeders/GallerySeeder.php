<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\PrimaryImage;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleryItems = [
            [
                'title' => [
                    'ar' => 'غرفة معيشة ذكية',
                    'en' => 'Smart Living Room'
                ],
                'description' => [
                    'ar' => 'تصميم عصري لغرفة معيشة مجهزة بأحدث أنظمة التحكم الذكي والإضاءة التفاعلية.',
                    'en' => 'Modern design for a living room equipped with the latest smart control systems and interactive lighting.'
                ],
                'image' => 'image.svg'
            ],
            [
                'title' => [
                    'ar' => 'نظام الأمان الذكي',
                    'en' => 'Smart Security System'
                ],
                'description' => [
                    'ar' => 'أقفال ذكية متطورة مع أنظمة التحكم بالدخول والمراقبة الآمنة.',
                    'en' => 'Advanced smart locks with access control systems and secure monitoring.'
                ],
                'image' => 'Image Column.svg'
            ],
            [
                'title' => [
                    'ar' => 'غرفة طعام فاخرة',
                    'en' => 'Luxury Dining Room'
                ],
                'description' => [
                    'ar' => 'مساحة طعام أنيقة مع إضاءة ذكية قابلة للتحكم وأنظمة صوتية متكاملة.',
                    'en' => 'Elegant dining space with controllable smart lighting and integrated audio systems.'
                ],
                'image' => 'image-3.svg'
            ],
            [
                'title' => [
                    'ar' => 'لوحة التحكم الذكية',
                    'en' => 'Smart Control Panel'
                ],
                'description' => [
                    'ar' => 'واجهة تحكم متطورة للتحكم في جميع أنظمة المنزل الذكي.',
                    'en' => 'Advanced control interface for managing all smart home systems.'
                ],
                'image' => 'image-1.svg'
            ],
            [
                'title' => [
                    'ar' => 'النظام الصوتي الذكي',
                    'en' => 'Smart Audio System'
                ],
                'description' => [
                    'ar' => 'سماعات ذكية عالية الجودة مع التحكم الصوتي المتقدم.',
                    'en' => 'High-quality smart speakers with advanced voice control.'
                ],
                'image' => 'image-2.svg'
            ],
            [
                'title' => [
                    'ar' => 'الإضاءة الذكية',
                    'en' => 'Smart Lighting'
                ],
                'description' => [
                    'ar' => 'أنظمة إضاءة ذكية قابلة للتخصيص مع التحكم في الألوان والشدة.',
                    'en' => 'Customizable smart lighting systems with color and intensity control.'
                ],
                'image' => 'Smart Door Lock V5 (1) 1.svg'
            ]
        ];

        $srcDir = public_path('assets/images');
        $destDir = public_path('attachments/primaryimages');
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        foreach ($galleryItems as $itemData) {
            $item = PrimaryImage::firstOrCreate(
                ['title->ar' => $itemData['title']['ar']],
                [
                    'title' => $itemData['title'],
                    'description' => $itemData['description'],
                    'image' => $itemData['image']
                ]
            );

            // Copy image file if exists
            $srcFile = $srcDir . DIRECTORY_SEPARATOR . $itemData['image'];
            if (File::exists($srcFile)) {
                $destFile = $destDir . DIRECTORY_SEPARATOR . $itemData['image'];
                if (!File::exists($destFile)) {
                    File::copy($srcFile, $destFile);
                }

                // Attach media using Spatie Media Library
                if ($item->getMedia('gallery_image')->isEmpty()) {
                    $item->addMedia($srcFile)
                        ->toMediaCollection('gallery_image');
                }
            }
        }
    }
}
