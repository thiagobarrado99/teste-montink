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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->decimal("total", 8, 2);

            $table->foreignId("client_id");
            $table->foreignId("coupon_id")->nullable();

            $table->timestamps();

            $table->foreign("client_id")->references("id")->on("clients");
            $table->foreign("coupon_id")->references("id")->on("coupons")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
