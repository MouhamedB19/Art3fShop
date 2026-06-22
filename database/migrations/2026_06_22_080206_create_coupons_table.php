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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string("code")->unique();
            $table->enum("type",["pourcentage","montant"]);
            $table->decimal("valeur",8,2);
            $table->integer("montant_min")->nullable();
            $table->date("date_debut");
            $table->date("date_fin");
            $table->integer("utilisation_max")->nullable();
            $table->integer("nombre_utilisations")->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
