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
        Schema::create('artistes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_d_artiste')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable(); // chemin vers la photo de l'artiste
            $table->boolean('Est_Artiste_Art3f')->default(false);
            $table->string('iban',255)->nullable();
            $table->string('CV')->nullable(); // chemin vers le CV de l'artiste
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade')->unique(); // lien vers la table users
            $table->foreignId('localisations_id')->nullable()->constrained('localisations')->onDelete('cascade')->onUpdate('cascade'); // lien vers la table localisations
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artistes');
    }
};
