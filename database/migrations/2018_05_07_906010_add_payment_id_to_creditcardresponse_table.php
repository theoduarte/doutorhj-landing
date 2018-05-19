<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentIdToCreditCardResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('creditcardresponse', function (Blueprint $table) {
    		$table->integer('payment_id')
    		->unsigned()
    		->nullable()
    		->after('return_message');
    		 
    		$table->foreign('payment_id')->references('id')->on('payments');
    	});
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::table('creditcardresponse', function (Blueprint $table) {
    	    $table->dropForeign('payments_payment_id_foreign');
    		$table->dropColumn('payment_id');
    	});
    }
}
