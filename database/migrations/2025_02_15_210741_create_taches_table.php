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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('description');
            $table->date('date_debut')->nullable();
            $table->date('date_echeance')->nullable();
            $table->unsignedBigInteger('personne_id')->nullable();
            $table->foreign('personne_id')->references('id')->on('personnes');
            $table->unsignedBigInteger('projet_id')->nullable();
            $table->foreign('projet_id')->references('id')->on('projets');
            $table->unsignedBigInteger('statut_id')->nullable();
            $table->foreign('statut_id')->references('id')->on('statuts');





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
