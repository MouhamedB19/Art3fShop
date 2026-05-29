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
        Schema::create('oeuvres', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->integer('annee_de_creation');
            $table->decimal('taux_reduction',3,2)->nullable();
            $table->string('photo_principale');
            $table->enum('orientation', ['portrait', 'paysage', 'carre']); // liste déroulante
            $table->string('description');
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->foreignId('support_id')->constrained('supports')->onDelete('cascade');
            $table->foreignId('artiste_id')->constrained('artistes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oeuvres');
    }
};
