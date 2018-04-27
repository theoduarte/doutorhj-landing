<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPacienteIdToPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('pedidos', function (Blueprint $table) {
    		$table->integer('cartao_id')
    		->unsigned()
    		->nullable()
    		->after('boleto_id');
    		 
    		$table->foreign('cartao_id')->references('id')->on('cartao_pacientes');
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
    		$table->dropForeign('pedidos_cartao_id_foreign');
    		$table->dropColumn('cartao_id');
    	});
    }
}
