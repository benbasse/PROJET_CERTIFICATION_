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
        Schema::create('maisons', function (Blueprint $table) {
            $table->id();
            $table->string('addresse');
            $table->integer('superficie');
            $table->integer('prix');
            $table->string('description');
            $table->string('image');
            $table->date('annee_construction');
            $table->integer('nombre_etage');
            $table->enum('type', ['R+1','R+2','R+3','R+4','R+5'])->default('R+1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maisons');
    }
};
