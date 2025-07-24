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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name", 128);
            $table->string("description", 256)->nullable()->default("Sem descrição");
            $table->string("picture", 512)->nullable();
            $table->decimal("price", 8, 2);
            
            $table->foreignId("product_id")->nullable();
            $table->foreignId("user_id");
            $table->timestamps();

            $table->foreign("product_id")->references("id")->on("products")->cascadeOnDelete();
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
