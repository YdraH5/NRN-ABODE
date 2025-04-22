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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('discover_description')->nullable();
            $table->text('designed_description')->nullable();
            $table->text('neary_description')->nullable();
            $table->text('apartment_description')->nullable();
            $table->string('gcash_number')->nullable();
            $table->string('gcash_qr_image')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
