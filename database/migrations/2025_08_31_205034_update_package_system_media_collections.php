<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // This migration will clean up old 'images' collection media
        // for PackageSystem models to prepare for the new structure
        // The new structure uses specific collections: 'image1', 'image2', 'video'

        // Note: Existing media in 'images' collection will need to be manually
        // reassigned or re-uploaded through the dashboard form

        // Optional: You can uncomment the following line to remove all existing
        // media for PackageSystem models if you want a clean start
        // Media::where('model_type', 'App\\Models\\PackageSystem')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No specific rollback needed as this doesn't change schema
    }
};
