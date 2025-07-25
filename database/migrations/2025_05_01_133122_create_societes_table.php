<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('societes', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('adresse')->nullable();
        $table->string('telephone')->nullable();
        $table->string('email')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societes');
    }
};
