<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendamentosAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos_atendimentos', function (Blueprint $table) {
            $table->integer('agendamento_id')->unsigned();
            $table->foreign('agendamento_id')->references('id')->on('agendamentos');

            $table->integer('atendimento_id')->unsigned();
            $table->foreign('atendimento_id')->references('id')->on('atendimentos');

            $table->primary(['agendamento_id', 'atendimento_id']);

            $table->softDeletes();
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
        Schema::dropIfExists('agendamentos_atendimentos');
    }
}