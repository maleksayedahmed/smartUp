<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_systems', function (Blueprint $table) {
            // drop global unique on slug if exists
            try {
                $table->dropUnique('package_systems_slug_unique');
            } catch (\Throwable $e) {
                // ignore if not exists
            }
            // add composite unique on (package_id, slug)
            $table->unique(['package_id', 'slug'], 'pkg_sys_package_slug_unique');
        });
    }

    public function down(): void
    {
        Schema::table('package_systems', function (Blueprint $table) {
            try {
                $table->dropUnique('pkg_sys_package_slug_unique');
            } catch (\Throwable $e) {
            }
            $table->unique('slug');
        });
    }
};


