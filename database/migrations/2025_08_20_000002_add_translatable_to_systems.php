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
            if (!Schema::hasColumn('systems', 'desctiption')) {
                $table->json('desctiption')->nullable()->after('title');
            }
            if (!Schema::hasColumn('systems', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('desctiption');
            }
        });

        if (
            Schema::hasColumn('systems', 'title_ar') &&
            Schema::hasColumn('systems', 'title_en') &&
            Schema::hasColumn('systems', 'desctiption_ar') &&
            Schema::hasColumn('systems', 'desctiption_en')
        ) {
            $systems = DB::table('systems')->select('id', 'title_ar', 'title_en', 'desctiption_ar', 'desctiption_en')->get();
            foreach ($systems as $s) {
                DB::table('systems')->where('id', $s->id)->update([
                    'title'       => json_encode(['ar' => $s->title_ar, 'en' => $s->title_en], JSON_UNESCAPED_UNICODE),
                    'desctiption' => json_encode(['ar' => $s->desctiption_ar, 'en' => $s->desctiption_en], JSON_UNESCAPED_UNICODE),
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
            if (Schema::hasColumn('systems', 'desctiption')) {
                $table->dropColumn('desctiption');
            }
            if (Schema::hasColumn('systems', 'title')) {
                $table->dropColumn('title');
            }
        });
    }
};


