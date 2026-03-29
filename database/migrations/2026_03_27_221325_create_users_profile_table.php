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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade')->comment('FK única vinculada ao usuário autenticado (Relacionamento 1:1)');
            $table->string('user_phone')->nullable()->comment('Número de contato com DDD e DDI');
            $table->string('user_role')->comment('Cargo ou função hierárquica do usuário na plataforma');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');

    }
};
