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
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->unique()->constrained()->onDelete('cascade')->comment('FK única vinculada ao ticket pai (Relacionamento 1:1)');
            $table->json('ticket_details_enriched_data')->comment('Descrição técnica detalhada, logs de erro ou especificações de hardware');
            $table->timestamp('ticket_details_processed_at')->comment('Armazena a data de processamento');
            $table->timestamp('ticket_details_notified_at')->nullable()->comment('Armazena a data de notificação');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_details');
    }
};
