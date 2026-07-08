<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // Pour les oeuvres favorites
    public function up(): void
    {
        Schema::create('tirage_client',function(Blueprint $table){
            $table->foreignId('tirage_favoris_id')->constrained('tirages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['tirage_favoris_id','client_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('tirage_client');
    }
};
