<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Pour le panier
    public function up(): void
    {
        Schema::create('client_tirage', function (Blueprint $table) {
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('tirage_id')->constrained('tirages');
            $table->integer('quantite');
            $table->primary(['client_id', 'tirage_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_tirage');
    }
};
