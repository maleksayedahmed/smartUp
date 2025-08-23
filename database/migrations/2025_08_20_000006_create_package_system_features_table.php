<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_system_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_system_id')->constrained('package_systems')->onDelete('cascade');
            $table->json('title');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_system_features');
    }
};


