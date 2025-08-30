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
        Schema::create('package_spec', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id') ->constrained('packages')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title_ar',255);
            $table->string('title_en',255);
            $table->string('description_ar',255);
            $table->string('description_en',255);
            $table->text('image')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_spec');
    }
};
