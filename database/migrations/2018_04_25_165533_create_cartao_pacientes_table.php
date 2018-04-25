<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCartaoPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartao_pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bandeira', 20)->nullable();
            $table->string('nome_impresso', 150)->nullable();
            $table->string('numero', 16)->nullable();
            $table->integer('ano_vencimento')->nullable();
            $table->integer('mes_vencimento')->nullable();
            $table->string('codigo_seg', 3)->nullable();
            $table->timestamp('created_at')->default(DB::raw('NOW()'));
            $table->timestamp('updated_at')->default(DB::raw('NOW()'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cartao_pacientes');
    }
}
