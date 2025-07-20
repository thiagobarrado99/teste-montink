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
        Schema::create('inventory_history', function (Blueprint $table) {
            $table->id();
            $table->integer("quantity");
            $table->string("description", 128);
            
            $table->foreignId("inventory_id");
            $table->foreignId("user_id")->nullable();
            $table->timestamps();

            $table->foreign("inventory_id")->references("id")->on("inventories")->cascadeOnDelete();
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_history');
    }
};
