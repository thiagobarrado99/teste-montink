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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("name", 256);
            $table->string("tax_id", 16)->nullable()->unique();
            $table->string("email", 256)->unique();
            $table->string("phone", 16)->unique();

            $table->string("zipcode", 16);
            $table->string("state", 32)->nullable();
            $table->string("city", 128)->nullable();
            $table->string("neighborhood", 256)->nullable();
            $table->string("address", 256)->nullable();
            $table->string("number", 16)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
