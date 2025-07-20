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
            $table->string("name", 64);
            $table->string("code", 16);
            
            $table->boolean("is_percentage")->default(false);
            $table->decimal("discount_value", 8, 2);
            $table->decimal("minimum_price", 8, 2)->nullable();
            $table->integer("max_uses")->nullable();
            $table->integer("total_uses")->default(0);

            $table->timestamp("expires_at");
            $table->foreignId("user_id");
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users");
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
