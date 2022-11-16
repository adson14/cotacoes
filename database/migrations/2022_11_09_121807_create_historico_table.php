<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Adson Souza
         * Este modelo de dados pode ser melhorado informando os tamanhos das colunas e os tipos, mas devido
         * ao tempo não achei crucial no momento
         */
        Schema::create('historico_cotacoes', function (Blueprint $table) {
            $table->id();
            $table->string('simbolo');
            $table->string('organizacao');
            $table->decimal('ultimo_preco',6,2);
            $table->integer('volume')->nullable();
            $table->string('moeda');
            $table->dateTime('ultima_atualizacao');
            $table->decimal('abertura',6,2)->nullable();
            $table->decimal('fechamento',6,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_cotacoes');
    }
}
