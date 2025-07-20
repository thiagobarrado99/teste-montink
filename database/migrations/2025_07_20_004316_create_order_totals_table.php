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
        Schema::create('order_totals', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id");
            $table->foreignId("product_id")->nullable();
            $table->boolean("is_discount")->default(false);
            $table->string("description", 128);

            $table->decimal("total", 8, 2);

            $table->timestamps();

            $table->foreign("order_id")->references("id")->on("orders")->cascadeOnDelete();
            $table->foreign("product_id")->references("id")->on("products")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_totals');
    }
};
