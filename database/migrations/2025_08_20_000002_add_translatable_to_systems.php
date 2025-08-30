<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('systems', function (Blueprint $table) {
            if (!Schema::hasColumn('systems', 'title')) {
                $table->json('title')->nullable()->after('id');
            }
            if (!Schema::hasColumn('systems', 'description')) {
                $table->json('description')->nullable()->after('title');
            }
            if (!Schema::hasColumn('systems', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('description');
            }
        });

        if (
            Schema::hasColumn('systems', 'title_ar') &&
            Schema::hasColumn('systems', 'title_en') &&
            Schema::hasColumn('systems', 'description_ar') &&
            Schema::hasColumn('systems', 'description_en')
        ) {
            $systems = DB::table('systems')->select('id', 'title_ar', 'title_en', 'description_ar', 'description_en')->get();
            foreach ($systems as $s) {
                DB::table('systems')->where('id', $s->id)->update([
                    'title'       => json_encode(['ar' => $s->title_ar, 'en' => $s->title_en], JSON_UNESCAPED_UNICODE),
                    'description' => json_encode(['ar' => $s->description_ar, 'en' => $s->description_en], JSON_UNESCAPED_UNICODE),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('systems', function (Blueprint $table) {
            if (Schema::hasColumn('systems', 'slug')) {
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('systems', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('systems', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};


