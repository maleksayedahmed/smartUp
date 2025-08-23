<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_features', function (Blueprint $table) {
            if (!Schema::hasColumn('package_features', 'title')) {
                $table->json('title')->nullable()->after('id');
            }
        });

        if (Schema::hasColumn('package_features', 'title_ar') && Schema::hasColumn('package_features', 'title_en')) {
            $rows = DB::table('package_features')->select('id', 'title_ar', 'title_en')->get();
            foreach ($rows as $row) {
                DB::table('package_features')->where('id', $row->id)->update([
                    'title' => json_encode(['ar' => $row->title_ar, 'en' => $row->title_en], JSON_UNESCAPED_UNICODE),
                ]);
            }
        }

        Schema::table('systems_features', function (Blueprint $table) {
            if (!Schema::hasColumn('systems_features', 'title')) {
                $table->json('title')->nullable()->after('id');
            }
        });

        if (Schema::hasColumn('systems_features', 'title_ar') && Schema::hasColumn('systems_features', 'title_en')) {
            $rows = DB::table('systems_features')->select('id', 'title_ar', 'title_en')->get();
            foreach ($rows as $row) {
                DB::table('systems_features')->where('id', $row->id)->update([
                    'title' => json_encode(['ar' => $row->title_ar, 'en' => $row->title_en], JSON_UNESCAPED_UNICODE),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('package_features', function (Blueprint $table) {
            if (Schema::hasColumn('package_features', 'title')) {
                $table->dropColumn('title');
            }
        });
        Schema::table('systems_features', function (Blueprint $table) {
            if (Schema::hasColumn('systems_features', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};


