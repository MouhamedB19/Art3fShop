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
        Schema::create('commande_livraison', function (Blueprint $table) {
            $table->foreignId('commande_id')->constrained('commandes');
            $table->foreignId('livraison_id')->constrained('livraisons');
            $table->primary(['commande_id', 'livraison_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_livraison');
    }
};
