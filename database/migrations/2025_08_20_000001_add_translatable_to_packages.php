<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'title')) {
                $table->json('title')->nullable()->after('id');
            }
            if (!Schema::hasColumn('packages', 'desc')) {
                $table->json('desc')->nullable()->after('title');
            }
            if (!Schema::hasColumn('packages', 'note')) {
                $table->json('note')->nullable()->after('desc');
            }
            if (!Schema::hasColumn('packages', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('note');
            }
        });

        // Backfill JSON from existing *_ar/_en fields if present
        if (Schema::hasColumn('packages', 'title_ar') && Schema::hasColumn('packages', 'title_en')) {
            $packages = DB::table('packages')->select('id', 'title_ar', 'title_en', 'desc_ar', 'desc_en', 'note_ar', 'note_en')->get();
            foreach ($packages as $p) {
                DB::table('packages')->where('id', $p->id)->update([
                    'title' => json_encode(['ar' => $p->title_ar, 'en' => $p->title_en], JSON_UNESCAPED_UNICODE),
                    'desc'  => json_encode(['ar' => $p->desc_ar,  'en' => $p->desc_en],  JSON_UNESCAPED_UNICODE),
                    'note'  => json_encode(['ar' => $p->note_ar,  'en' => $p->note_en],  JSON_UNESCAPED_UNICODE),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            if (Schema::hasColumn('packages', 'slug')) {
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('packages', 'note')) {
                $table->dropColumn('note');
            }
            if (Schema::hasColumn('packages', 'desc')) {
                $table->dropColumn('desc');
            }
            if (Schema::hasColumn('packages', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};


