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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade')->comment('ID do projeto ao qual este ticket está vinculado');
            $table->foreignId('user_id')->constrained()->comment('ID do usuário que realizou a abertura do ticket');
            $table->string('ticket_subject')->comment('Assunto resumido ou título da ocorrência');
            $table->enum('ticket_status', ['open', 'closed'])->default('open')->comment('Estado atual do ticket: open (aberto), closed (fechado)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
