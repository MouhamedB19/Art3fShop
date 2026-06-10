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
        Schema::create('artiste_salon', function (Blueprint $table) {
            $table->foreignId('artiste_id')->constraint('artistes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('salon_id')->constraint('salons')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['artiste_id','salon_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artiste_salon');
    }
};
