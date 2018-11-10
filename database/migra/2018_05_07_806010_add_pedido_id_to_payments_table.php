<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPedidoIdToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('payments', function (Blueprint $table) {
    		$table->integer('pedido_id')
				  ->unsigned()
				  ->nullable()
				  ->after('paciente_id');
    		
			$table->foreign('pedido_id')->references('id')->on('pedidos');
    	});
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('payments', function (Blueprint $table) {
    	    $table->dropForeign('payments_pedido_id_foreign');
    	    $table->dropColumn('pedido_id');
    	});
    }
}