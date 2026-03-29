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
            $table->string('ticket_title', 50)->comment('Armazena título da ocorrência');
            $table->text('ticket_description')->comment('Armazena a descrição da ocorrencia');
            $table->enum('ticket_status', ['pending', 'processing', 'done', 'error'])->default('pending')->comment('Estado atual do ticket');
            $table->string('ticket_attachment')->nullable()->comment('Armazena caminho do anexo');
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
