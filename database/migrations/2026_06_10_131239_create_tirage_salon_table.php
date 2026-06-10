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
        Schema::create('tirage_salon', function (Blueprint $table) {
            $table->foreignId('tirage_id')->constraint('tirages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('salon_id')->constraint('salons')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['tirage_id','salon_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oeuvre_salon');
    }
};
