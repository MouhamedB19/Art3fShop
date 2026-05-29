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
        Schema::create('emplacements_pubs', function (Blueprint $table) {
            $table->string('code')->primary();      // 'catalogue', 'home_une'...
            $table->string('label');               // 'Page Catalogue', 'Home - Artiste à la Une'
            $table->string('format')->nullable();  // '728x90px', 'full-width'...
            $table->decimal('prix', 8, 2);         // tarif de base de l'emplacement
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emplacements_pubs');
    }
};
