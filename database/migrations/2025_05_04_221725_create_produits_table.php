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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('numero_inventaire')->unique();
            $table->string('designation');
            $table->integer('quantite_stock');
            $table->string('unite');
            $table->foreignId('societe_id')->constrained('societes')->onDelete('cascade');
            $table->string('bon_commande')->nullable();
            $table->date('date_reception')->nullable();
            $table->foreignId('affectation_id')->nullable()->constrained('affectations')->onDelete('set null');
            $table->text('remarque')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
