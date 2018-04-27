<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPacienteIdToCartaoPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('cartao_pacientes', function (Blueprint $table) {
    		$table->integer('paciente_id')
    		->unsigned()
    		->nullable()
    		->after('codigo_seg');
    		 
    		$table->foreign('paciente_id')->references('id')->on('pacientes');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('cartao_pacientes', function (Blueprint $table) {
    		$table->dropForeign('cartao_pacientes_paciente_id_foreign');
    		$table->dropColumn('paciente_id');
    	});
    }
}
