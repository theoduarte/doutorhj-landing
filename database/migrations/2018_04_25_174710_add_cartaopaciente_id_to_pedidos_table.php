<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCartaopacienteIdToPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('pedidos', function (Blueprint $table) {
    		$table->integer('paciente_id')
    		->unsigned()
    		->nullable()
    		->after('boleto_id');
    		 
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
    	Schema::table('pedidos', function (Blueprint $table) {
    		$table->dropForeign('pedidos_paciente_id_foreign');
    		$table->dropColumn('paciente_id');
    	});
    }
}
