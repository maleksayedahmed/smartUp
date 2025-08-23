<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update banners table
        Schema::table('banners', function (Blueprint $table) {
            $table->json('title')->after('id');
            $table->json('description')->after('title');
        });

        // Update cards table  
        Schema::table('cards', function (Blueprint $table) {
            $table->json('title')->after('id');
            $table->json('description')->after('title');
        });

        // Update main_systems table
        Schema::table('main_systems', function (Blueprint $table) {
            $table->json('name')->after('id');
            $table->json('description')->after('name');
        });

        // Update primary_images table
        Schema::table('primary_images', function (Blueprint $table) {
            $table->json('title')->after('id');
            $table->json('description')->after('title');
        });

        // Migrate existing data
        $this->migrateExistingData();

        // Drop old columns
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'title_en', 'desctiption_ar', 'desctiption_en']);
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'title_en', 'desctiption_ar', 'desctiption_en']);
        });

        Schema::table('main_systems', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'name_en', 'description_ar', 'description_en']);
        });

        Schema::table('primary_images', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'title_en']);
        });
    }

    public function down(): void
    {
        // Restore old columns
        Schema::table('banners', function (Blueprint $table) {
            $table->string('title_ar', 255);
            $table->string('title_en', 255);
            $table->string('desctiption_ar', 255);
            $table->string('desctiption_en', 255);
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->string('title_ar', 255);
            $table->string('title_en', 255);
            $table->string('desctiption_ar', 255);
            $table->string('desctiption_en', 255);
        });

        Schema::table('main_systems', function (Blueprint $table) {
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('description_ar');
            $table->text('description_en');
        });

        Schema::table('primary_images', function (Blueprint $table) {
            $table->string('title_ar');
            $table->string('title_en');
        });

        // Drop JSON columns
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });

        Schema::table('main_systems', function (Blueprint $table) {
            $table->dropColumn(['name', 'description']);
        });

        Schema::table('primary_images', function (Blueprint $table) {
            $table->dropColumn(['title', 'description']);
        });
    }

    private function migrateExistingData(): void
    {
        // Migrate banners
        $banners = DB::table('banners')->get();
        foreach ($banners as $banner) {
            DB::table('banners')->where('id', $banner->id)->update([
                'title' => json_encode([
                    'ar' => $banner->title_ar ?? '',
                    'en' => $banner->title_en ?? '',
                ]),
                'description' => json_encode([
                    'ar' => $banner->desctiption_ar ?? '',
                    'en' => $banner->desctiption_en ?? '',
                ])
            ]);
        }

        // Migrate cards
        $cards = DB::table('cards')->get();
        foreach ($cards as $card) {
            DB::table('cards')->where('id', $card->id)->update([
                'title' => json_encode([
                    'ar' => $card->title_ar ?? '',
                    'en' => $card->title_en ?? '',
                ]),
                'description' => json_encode([
                    'ar' => $card->desctiption_ar ?? '',
                    'en' => $card->desctiption_en ?? '',
                ])
            ]);
        }

        // Migrate main_systems
        $systems = DB::table('main_systems')->get();
        foreach ($systems as $system) {
            DB::table('main_systems')->where('id', $system->id)->update([
                'name' => json_encode([
                    'ar' => $system->name_ar ?? '',
                    'en' => $system->name_en ?? '',
                ]),
                'description' => json_encode([
                    'ar' => $system->description_ar ?? '',
                    'en' => $system->description_en ?? '',
                ])
            ]);
        }

        // Migrate primary_images
        $images = DB::table('primary_images')->get();
        foreach ($images as $image) {
            DB::table('primary_images')->where('id', $image->id)->update([
                'title' => json_encode([
                    'ar' => $image->title_ar ?? '',
                    'en' => $image->title_en ?? '',
                ]),
                'description' => json_encode([
                    'ar' => 'وصف تفصيلي للصورة وما تحتويه من أنظمة ذكية وحلول تقنية متطورة.',
                    'en' => 'Detailed description of the image and its smart systems and advanced technical solutions.',
                ])
            ]);
        }
    }
};
