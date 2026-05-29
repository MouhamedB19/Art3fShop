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
        Schema::create('oeuvre_selection', function (Blueprint $table) {
            $table->foreignId('selection_id')->constrained()->cascadeOnDelete();
            $table->foreignId('oeuvre_id')->constrained()->cascadeOnDelete();
            $table->primary(['selection_id', 'oeuvre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oeuvre_selection');
    }
};
