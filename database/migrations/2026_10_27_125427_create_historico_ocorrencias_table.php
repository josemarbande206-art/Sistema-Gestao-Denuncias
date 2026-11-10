<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historico_ocorrencias', function (Blueprint $table) {
            $table->id();

            // Ocorrência à qual pertence a alteração.
            $table->unsignedInteger('ocorrencia_id');

            // Estados antes e depois da alteração.
            $table->string('estado_anterior', 30)->nullable();
            $table->string('estado_novo', 30);

            // Será preenchido quando a autenticação do operador estiver integrada.
            $table->unsignedInteger('operador_id')->nullable();

            // Campo opcional para explicar a alteração.
            $table->text('observacao')->nullable();

            // Data e hora do registo.
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('ocorrencia_id')
                ->references('id')
                ->on('ocorrencias')
                ->cascadeOnDelete();

            $table->foreign('operador_id')
                ->references('id')
                ->on('utilizadores')
                ->nullOnDelete();

            $table->index(['ocorrencia_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historico_ocorrencias');
    }
};