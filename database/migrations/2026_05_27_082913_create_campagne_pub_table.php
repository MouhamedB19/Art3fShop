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
        Schema::create('campagne_pubs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artiste_id')->constrained()->cascadeOnDelete();
            $table->foreignId('oeuvre_id')->nullable()->constrained()->nullOnDelete()->cascadeOnDelete();
            $table->enum('type', ['artiste', 'oeuvre']);
            $table->enum('statut', ['en_attente', 'active', 'terminee', 'annulee'])->default('en_attente');
            $table->string('emplacement_id');
            $table->foreign('emplacement_id')->references('code')->on('emplacements_pubs')->OnDelete("cascade")->onUpdate("cascade");
            $table->string('visuel')->nullable();
            $table->string('lien_cible');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->decimal('montant_paye', 8, 2);
            $table->enum('paiement_statut', ['impaye', 'paye', 'rembourse'])->default('impaye');
            $table->string('stripe_paiement_id')->nullable();
            $table->unsignedBigInteger('impressions')->default(0); //calcul CTR = clics/impressions * 100
            $table->unsignedBigInteger('clics')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campagne_pubs');
    }
};
