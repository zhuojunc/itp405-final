<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_restaurant', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('votes');
            $table->foreignId('party_id')->constrained('parties')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('restaurant_id')->constrained('restaurants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('party_restaurant');
    }
};
