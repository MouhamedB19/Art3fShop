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
        Schema::create('oeuvre_theme', function (Blueprint $table) {
            $table->foreignId('oeuvre_id')->constrained('oeuvres')->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId('theme_id')->constrained('themes')->onDelete("cascade")->onUpdate("cascade");
            $table->primary(['oeuvre_id', 'theme_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oeuvre_theme');
    }
};
