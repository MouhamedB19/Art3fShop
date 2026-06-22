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
        Schema::create('coupon_commande', function (Blueprint $table) {
            $table->foreignId("commande_id")->constrained("commandes")->onUpdate("cascade")->onDelete("cascade");
            $table->foreignId("coupon_id")->constrained("coupons")->onUpdate("cascade")->onDelete("cascade");
            $table->primary(["commande_id","coupon_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_commande');
    }
};
