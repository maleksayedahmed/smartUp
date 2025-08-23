<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('primary_images', function (Blueprint $table) {
            $table->boolean('is_main')->default(0)->after('id'); // يمكنك تغيير 'after' حسب الحاجة
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('primary_images', function (Blueprint $table) {
            $table->dropColumn('is_main');
        });
    }
};
