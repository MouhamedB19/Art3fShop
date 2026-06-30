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
        Schema::create('tirages', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('oeuvre_id');
            $table->integer('numero');
            $table->unique(['oeuvre_id', 'numero']); 
            $table->foreign('oeuvre_id')->references('id')->on('oeuvres')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['disponible', 'vendu'])->default('disponible');
            $table->decimal('prix', 10, 2);
            $table->boolean('encadrement')->nullable();
            $table->boolean('pret_a_accrocher')->nullable();
            $table->foreignId('dimensions_id')->constrained('dimensions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('commande_id')->nullable()->constrained('commandes')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('avec_cadre')->nullable();
            $table->index('oeuvre_id');
            $table->index('dimensions_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tirages');
    }
};
