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
        Schema::create('artiste_client', function (Blueprint $table) {
            $table->foreignId('artiste_id')->constrained('artistes');
            $table->foreignId('client_id')->constrained('clients');
            $table->primary(['artiste_id', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artiste_client');
    }
};
